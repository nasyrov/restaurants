const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js'
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans]
            }
        }
    },
    variants: {
        extend: {}
    },
    plugins: [
        require('@tailwindcss/forms')
    ]
}
