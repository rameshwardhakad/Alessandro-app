/** @type {import("prettier").Config} */
const config = {
  printWidth: 100,
  trailingComma: 'all',
  tabWidth: 2,
  semi: false,
  singleQuote: true,
  vueIndentScriptAndStyle: true,
  singleAttributePerLine: false,
  overrides: [
    {
      files: ['*.md'],
      options: {
        tabWidth: 4,
      },
    },
    {
      files: ['*.php'],
      options: {
        phpVersion: '8.1',
        trailingCommaPHP: true,
        braceStyle: 'per-cs', // 'per-cs' | '1tbs'
        tabWidth: 4,
      },
    },
  ],
  tailwindConfig: './tailwind.config.js',
  plugins: [
    'prettier-plugin-tailwindcss',
    '@prettier/plugin-php'
  ],
}

export default config
