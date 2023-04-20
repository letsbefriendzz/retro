module.exports = {
    purge: ['./resources/**/*.blade.php', './resources/js/Pages/**/*.js', './resources/js/Pages/**/*.vue'],
    darkMode: 'media',
    theme: {
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [require("daisyui")],
};
