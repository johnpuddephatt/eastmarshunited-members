const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: ['./storage/framework/views/*.php', './resources/views/**/*.blade.php'],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Rockford Sans', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: theme => ({
             'background-lines': "url('/images/background-lines-horizontal.svg')"
            })
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
