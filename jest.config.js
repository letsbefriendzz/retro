module.exports = {
    testEnvironment: 'jsdom',
    moduleFileExtensions: ['js', 'json', 'vue'],
    transform: {
        '^.+\\.vue$': 'vue-jest',
        '^.+\\.(js|jsx)$': 'babel-jest',
    },
    moduleNameMapper: {
        '^@/(.*)$': '<rootDir>/resources/js/$1',
    },
    testMatch: [
        '<rootDir>/tests/js/**/*.spec.(js|jsx|ts|tsx)',
    ],
    transformIgnorePatterns: [
        'node_modules/(?!(axios)/)',
    ],
};
