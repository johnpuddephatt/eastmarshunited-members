<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $proposal->title}}
        </h2>

        @if(\Auth::user()->id == $proposal->user->id)
        <x-button-link href="{{ route('proposal.edit', ['proposal' => $proposal]) }}">
            Edit
        </x-button-link>

        @endif
    </x-slot>


    <x-panel-card>

        <h2 class="mt-4 mb-2 text-3xl font-bold">{{ $proposal->title}}</h2>
        <div class="mb-2">
            Categories:
            @foreach($proposal->categories as $category)
            <x-badge type="info" :text="$category->name" />
            @endforeach
        </div>
        <ul class="flex flex-row mb-8 space-x-4 text-gray-600">
            @if($proposal->type)<li>Type: {{ $proposal->type }}</li>@endif
            @if($proposal->places)<li>Places: {{ $proposal->places }} </li>@endif
            @if($proposal->hours)<li>Hours: {{ $proposal->hours }}</li>@endif
        </ul>

        <div class="mb-8 prose prose-xl">
            {!! nl2br($proposal->description) !!}
        </div>

        @if(\Auth::user()->pledges->where('proposal_id', $proposal->id)->first())

        <x-alert title="You’ve signed up" message="We’ll let you know when this is confirmed." />

        @elseif(\Auth::user()->id == $proposal->user->id)
        <h3 class="mt-6 mb-3 text-xl font-bold">Responses</h3>

        @forelse ($proposal->exchanges as $exchange)
        <div class="flex items-center justify-between w-full mb-3 space-x-4 ">
            <p>{{ $exchange->source_user->name }}
                <span x-data="{}" class="px-3 pb-0.5 ml-2 text-xs align-middle rounded-full"
                    :class="{ 'bg-yellow-200 text-yellow-900' : '{{ $exchange->status }}' == 'pending', 'bg-green-200 text-green-900' : '{{ $exchange->status }}' == 'complete', 'bg-blue-200 text-blue-900' : '{{ $exchange->status }}' == 'approved' }">{{ $exchange->status }}</span>


            </p>
            <div class="flex space-x-1">
                @if($exchange->messages->count())
                <div x-data="{ open: false }">
                    <x-button x-on:click="open = true">View messages</x-button>
                    <template x-if="open">
                        <x-modal title="Message history">
                            @foreach($exchange->messages as $message)
                            <div class="flex py-3 my-4 space-x-2">
                                <div class="text-left">
                                    <div class="text-sm">{{ $message->sender->name }}</div>
                                    <div class="text-gray-500 tex xt-xs">{{$message->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                <div class="px-3 py-1 mb-auto -mt-1 text-sm bg-gray-100 rounded-lg">
                                    {!! $message->content !!}
                                </div>
                            </div>
                            @endforeach
                            <div class="flex content-center mt-8 space-x-4 text-center">
                                <x-button x-on:click.prevent="open = false">Close</x-button>
                            </div>
                        </x-modal>
                    </template>
                </div>
                @endif
                @if($exchange->status == 'pending')
                <div x-data="{ open: false }">
                    <x-button x-on:click="open = true">Approve</x-button>
                    <template x-if="open">
                        <x-modal title="Approve">
                            <form method="POST"
                                action="{{ route('exchange.approve', ['exchange' => $exchange, 'proposal' => $proposal->id ]) }}">
                                @csrf
                                <x-label for="message-approve">Add a message (optional)</x-label>
                                <x-textarea id="message-approve" class="w-full h-40" name="message"></x-textarea>
                                <div class="flex content-center mt-8 space-x-2 text-center">
                                    <x-button x-on:click.prevent="open = false">Cancel</x-button>
                                    <x-button>Confirm</x-button>
                                </div>
                            </form>
                        </x-modal>
                    </template>
                </div>
                @elseif($exchange->status == 'approved')
                <div x-data="{ open: false }">
                    <x-button x-on:click="open = true">Mark as complete</x-button>
                    <template x-if="open">
                        <x-modal title="Mark as complete">
                            <form method="POST"
                                action="{{ route('exchange.complete', ['exchange' => $exchange, 'proposal' => $proposal->id ]) }}">
                                @csrf
                                <x-label for="hours">Confirm number of hours</x-label>
                                <x-input id="hours" name="hours" :value="$proposal->hours"></x-input>
                                <x-label class="mt-4" for="message-complete">Add a message (optional)</x-label>
                                <x-textarea class="w-full h-30" id="message-complete" name="message"></x-textarea>
                                <div class="flex content-center mt-8 space-x-2 text-center">
                                    <x-button x-on:click.prevent="open = false">Cancel</x-button>
                                    <x-button>Confirm</x-button>
                                </div>
                            </form>
                        </x-modal>
                    </template>
                </div>
                @endif
            </div>
        </div>
        @empty
        No one has responded yet.

        @endforelse
        @else

        <h3 class="mt-6 mb-3 text-xl font-bold">Sign up to this</h3>
        <div x-data="{ open: false }">
            <x-button x-on:click="open = true">I’m
                interested</x-button>

            <template x-if="open">
                <x-modal title="Confirm your interest">
                    <form method="POST" action="{{ route('exchange.create', ['proposal' => $proposal->id ]) }}">
                        @csrf
                        <h3>Add a message (optional)</h3>
                        <x-textarea class="w-full h-40" name="message"></x-textarea>
                        <div class="flex mt-8 space-x-4 text-center">
                            <x-button x-on:click="open = false">Cancel</x-button>
                            <x-button>Confirm</x-button>
                        </div>
                    </form>
                </x-modal>
            </template>

        </div>
        @endif




    </x-panel-card>




</x-app-layout>