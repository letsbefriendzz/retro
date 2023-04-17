module.exports = {
    purge: ['./resources/**/*.blade.php', './resources/js/Pages/**/*.js', './resources/js/Pages/**/*.vue'],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [require("daisyui")],
};
