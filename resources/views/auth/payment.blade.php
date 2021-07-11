<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-40 h-auto" />
            </a>
        </x-slot>

        <form id="amount-form">
            <h3 class="text-2xl font-bold my-4">Payment amount</h3>
            <p class="mb-2">To become a member you must pay a minimum of £1. This buys you a share of the organisation and lets you vote on how it’s run.</p>
            <p class="mb-6">You can choose to pay more than £1. Any amount over £1 will be counted as a donation towards the running of East Marsh United.</p>

            <h3 class="text-lg font-bold my-2">Select payment amount</h3>
            <div class="flex justify-center items-center mb-4">
                <div class="mr-4">
                    <input checked type="radio" id="amount-100" name="amount" value="100">
                    <label for="amount-100">£1</label>
                </div>
                <div class="mr-4">
                    <input type="radio" id="amount-500" name="amount" value="500">
                    <label for="amount-500">£5</label>
                </div>
                <div class="mr-4">
                    <input type="radio" id="amount-1000" name="amount" value="1000">
                    <label for="amount-1000">£10</label>
                </div>
                <div class="flex items-center">
                    <input class="mr-1" type="radio" id="amount-custom" name="amount" value="custom">
                    <label for="amount-custom">Other</label>
                    <div class="ml-4 hide-unless-sibling-checked">
                    £
                    <x-input class="w-24" id="amount-custom-value" name="amount-custom" type="number" min="1" value="20"></x-input>
                    </div>
                </div>
            </div>



            <x-button class="w-full text-center" id="next">Next</x-button>
        </form>
        <form id="payment-form">
            <h3 class="text-xl font-bold my-4">Enter your card details</h3>

            <div id="card-element">
                <!--Stripe.js injects the Card Element-->
            </div>
            <x-button class="w-full mt-4" id="submit">
                <div class="spinner hidden" id="spinner"></div>
                <span id="button-text">Pay</span>
            </x-button>
            <p id="card-error" role="alert"></p>
            {{-- <p class="result-message hidden">
                Payment succeeded. Please wait...
            </p> --}}
        </form>

        <script src="https://js.stripe.com/v3/"></script>
        <script type="text/javascript">
            // Create an instance of the Stripe object with your publishable API key
            var stripe = Stripe("{{ config('services.stripe.public_key') }}");


            var paymentForm = document.getElementById("payment-form");
            var amountForm = document.getElementById("amount-form");
            paymentForm.classList.add('hidden');

            document.getElementById("next").addEventListener('click', (e)=>{
                e.preventDefault();
                paymentForm.classList.remove('hidden');
                amountForm.classList.add('hidden');
                let paymentAmount = (document.querySelector('#amount-form input[type=radio]:checked').value == 'custom') ? document.getElementById("amount-custom-value").value * 100 : document.querySelector('#amount-form input[type=radio]:checked').value;
                setupPaymentForm(paymentAmount);
            })


            function setupPaymentForm(amount) {
                // Disable the button until we have Stripe set up on the page
                document.querySelector("button").disabled = true;
                fetch("{{ route('register.checkout') }}", {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            "X-CSRF-Token": document.head.querySelector("[name~=csrf-token][content]").content
                        },
                        body: JSON.stringify({
                            'amount': amount
                        })
                    })
                    .then(function(result) {
                        return result.json();
                    })
                    .then(function(data) {
                        var elements = stripe.elements();
                        var style = {
                            base: {
                                color: "#32325d",
                                fontFamily: 'Arial, sans-serif',
                                fontSmoothing: "antialiased",
                                fontSize: "16px",
                                "::placeholder": {
                                    color: "#32325d"
                                }
                            },
                            invalid: {
                                fontFamily: 'Arial, sans-serif',
                                color: "#fa755a",
                                iconColor: "#fa755a"
                            }
                        };
                        var card = elements.create("card", {
                            style: style
                        });
                        // Stripe injects an iframe into the DOM
                        card.mount("#card-element");
                        card.on("change", function(event) {
                            // Disable the Pay button if there are no card details in the Element
                            document.querySelector("button").disabled = event.empty;
                            document.querySelector("#card-error").textContent = event.error ? event.error.message : "";
                        });
                        paymentForm.addEventListener("submit", function(event) {
                            event.preventDefault();
                            // Complete payment when the submit button is clicked
                            payWithCard(stripe, card, data.clientSecret);
                        });
                    });
                // Calls stripe.confirmCardPayment
                // If the card requires authentication Stripe shows a pop-up modal to
                // prompt the user to enter authentication details without leaving your page.
                var payWithCard = function(stripe, card, clientSecret) {
                    loading(true);
                    stripe
                        .confirmCardPayment(clientSecret, {
                            payment_method: {
                                card: card
                            }
                        })
                        .then(function(result) {
                            if (result.error) {
                                // Show error to your customer
                                showError(result.error.message);
                            } else {
                                // The payment succeeded!
                                orderComplete(result.paymentIntent.id);
                            }
                        });
                };
                /* ------- UI helpers ------- */
                // Shows a success message when the payment is complete
                var orderComplete = function(paymentIntentId) {
                    // loading(false);
                    // document.querySelector(".result-message").classList.remove("hidden");
                    // document.querySelector("button").disabled = true;
                    // setTimeout(()=>{
                        window.location = '/register/complete';
                    // }, 1000);
                };
                // Show the customer the error from Stripe if their card fails to charge
                var showError = function(errorMsgText) {
                    loading(false);
                    var errorMsg = document.querySelector("#card-error");
                    errorMsg.textContent = errorMsgText;
                    setTimeout(function() {
                        errorMsg.textContent = "";
                    }, 4000);
                };
                // Show a spinner on payment submission
                var loading = function(isLoading) {
                    if (isLoading) {
                        // Disable the button and show a spinner
                        document.querySelector("button").disabled = true;
                        document.querySelector("#spinner").classList.remove("hidden");
                        document.querySelector("#button-text").classList.add("hidden");
                    } else {
                        document.querySelector("button").disabled = false;
                        document.querySelector("#spinner").classList.add("hidden");
                        document.querySelector("#button-text").classList.remove("hidden");
                    }
                };
            }

        </script>

        <style>
            form {

            }

            input {
                border-radius: 6px;
                margin-bottom: 6px;
                padding: 12px;
                border: 1px solid rgba(50, 50, 93, 0.1);
                height: 44px;
                font-size: 16px;
                width: 100%;
                background: white;
            }

            .result-message {
                line-height: 22px;
                font-size: 16px;
            }

            .result-message a {
                color: rgb(89, 111, 214);
                font-weight: 600;
                text-decoration: none;
            }

            .hidden {
                display: none;
            }

            #card-error {
                color: rgb(105, 115, 134);
                text-align: left;
                font-size: 13px;
                line-height: 17px;
                margin-top: 12px;
            }

            #card-element {
                border-radius: 4px 4px 0 0;
                padding: 12px;
                border: 1px solid rgba(50, 50, 93, 0.1);
                height: 44px;
                width: 100%;
                background: white;
            }

            #payment-request-button {
                margin-bottom: 32px;
            }

            /* spinner/processing state, errors */
            .spinner,
            .spinner:before,
            .spinner:after {
                border-radius: 50%;
            }

            .spinner {
                color: #ffffff;
                font-size: 22px;
                text-indent: -99999px;
                margin: 0px auto;
                position: relative;
                width: 20px;
                height: 20px;
                box-shadow: inset 0 0 0 2px;
                -webkit-transform: translateZ(0);
                -ms-transform: translateZ(0);
                transform: translateZ(0);
            }

            .spinner:before,
            .spinner:after {
                position: absolute;
                content: "";
            }

            .spinner:before {
                width: 10.4px;
                height: 20.4px;
                background: #5469d4;
                border-radius: 20.4px 0 0 20.4px;
                top: -0.2px;
                left: -0.2px;
                -webkit-transform-origin: 10.4px 10.2px;
                transform-origin: 10.4px 10.2px;
                -webkit-animation: loading 2s infinite ease 1.5s;
                animation: loading 2s infinite ease 1.5s;
            }

            .spinner:after {
                width: 10.4px;
                height: 10.2px;
                background: #5469d4;
                border-radius: 0 10.2px 10.2px 0;
                top: -0.1px;
                left: 10.2px;
                -webkit-transform-origin: 0px 10.2px;
                transform-origin: 0px 10.2px;
                -webkit-animation: loading 2s infinite ease;
                animation: loading 2s infinite ease;
            }

            @-webkit-keyframesloading {
                0% {
                    -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }

            @keyframesloading {
                0% {
                    -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }

            @mediaonly screen and (max-width: 600px) {
                form {
                    width: 80vw;
                }
            }
        </style>

    </x-auth-card>
</x-guest-layout>
