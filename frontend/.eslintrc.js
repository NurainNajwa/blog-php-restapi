module.exports = {
    root: true,
    env: {
      browser: true,
      node: true,
    },
    extends: [
      'eslint:recommended',
      'plugin:vue/recommended',
      'airbnb-base', // or any other style guide you chose
    ],
    parserOptions: {
      parser: 'babel-eslint',
      ecmaVersion: 2020,
      sourceType: 'module',
      babelOptions: {
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
      },
    },
    rules: {
      // Add your custom rules here
      'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
      'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
      'vue/no-unused-components': 'warn',
    },
  };
  