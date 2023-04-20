module.exports = {
    purge: ['./resources/**/*.blade.php', './resources/js/Pages/**/*.js', './resources/js/Pages/**/*.vue'],
    darkMode: 'media', // or 'media' or 'class'
    theme: {
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [require("daisyui")],
};
