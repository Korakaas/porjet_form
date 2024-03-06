/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  darkMode: 'class',
  theme: {
    extend: {},
  },
  plugins: [ require('@tailwindcss/aspect-ratio'), require('@tailwindcss/forms'),],
}
