/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./assets/**/*.js', './templates/**/*.html.twig'],
  theme: {
    extend: {
      keyframes: {
        fadeInOut: {
          '0%': { opacity: 0 },
          '10%': { opacity: 100 },
          '70%': { opacity: 100 },
          '100%': { opacity: 0 },
        },
      },
      animation: {
        fadeInOut: 'fadeInOut 6s ease-in-out',
      },
    },
  },
  plugins: [],
};
