module.exports = {
    presets: [
        [
            '@babel/preset-env',
            {
                targets: {
                    node: 'current',
                },
            },
        ],
    ],
    plugins: [
        '@babel/plugin-transform-runtime',
        'babel-plugin-transform-vue-jsx',
    ],
};
