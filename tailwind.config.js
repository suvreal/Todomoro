/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.vue',
    './resources/**/*.js',
    './resources/**/*.ts',
  ],
  theme: {
      extend: {
          keyframes: {
              'gradient-x': {
                  '0%, 100%': { 'background-position': '0% 50%' },
                  '50%': { 'background-position': '100% 50%' },
              },
              fadeInUp: {
                  '0%': { opacity: '0', transform: 'translateY(20px)' },
                  '100%': { opacity: '1', transform: 'translateY(0)' },
              },
          },
          animation: {
              'gradient-x': 'gradient-x 30s ease infinite',
              'fadeInUp': 'fadeInUp 0.5s ease forwards',
          },
      },
  },
  plugins: [
      require('@tailwindcss/forms'),
      require('flowbite/plugin'),
  ],
}
