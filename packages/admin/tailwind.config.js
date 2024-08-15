import defaultTheme from 'tailwindcss/defaultTheme'
import aspectRatio from '@tailwindcss/aspect-ratio'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: ['./resources/**/*.{js,jsx,ts,tsx,vue,php}'],
  safelist: [
    'bg-gray-100',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter var', ...defaultTheme.fontFamily.sans],
      },
      width: {
        '1/7': '14.2857143%',
      },
      spacing: {
        7.5: '1.875rem',
      },
    },
  },
  plugins: [
    forms,
    aspectRatio,
    typography,
  ],
}
