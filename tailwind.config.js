/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./index.php",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('flowbite/plugin'),
    require('flowbite-typography'),
  ],
}

