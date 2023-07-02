/** @type {import('tailwindcss').Config} */
module.exports = {
  purge: [],
  darkMode: false,
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      gridTemplateColumns: {
        'footer': 'repeat(auto-fit, minmax(27rem, 1fr))',
      }
    },
  },
  variants: {},
  plugins: [],
}

