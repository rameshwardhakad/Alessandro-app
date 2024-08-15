module.exports = {
  env: {
    browser: true,
    es6: true,
    node: true,
  },
  extends: [
    'eslint:recommended',
    'plugin:vue/vue3-recommended',
    '@vue/eslint-config-typescript',
    'prettier',
  ],
  parser: 'vue-eslint-parser',
  parserOptions: {
    parser: '@typescript-eslint/parser',
    sourceType: 'module',
  },
  plugins: ['prettier', 'sort-destructure-keys'],
  root: true,
  rules: {
    'no-alert': 'warn',
    'no-console': 'off',
    'no-debugger': 'warn',
    'sort-destructure-keys/sort-destructure-keys': ['warn', { caseSensitive: false }],
    'sort-imports': [
      'warn',
      {
        ignoreDeclarationSort: true,
      },
    ],
    // 'sort-keys': ['warn', 'asc'],
    // 'typescript-sort-keys/interface': 'warn',
    // 'typescript-sort-keys/string-enum': 'warn',
    'vue/match-component-import-name': 'error',
    'vue/multi-word-component-names': 'off',
    'vue/no-v-html': 'off',
    'vue/sort-keys': [
      'off',
      'asc',
      {
        caseSensitive: true,
        ignoreChildrenOf: ['model'],
        ignoreGrandchildrenOf: ['computed', 'directives', 'inject', 'props', 'watch'],
        minKeys: 2,
        natural: false,
      },
    ],
  },
}
