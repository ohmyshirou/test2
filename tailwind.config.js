/** @type {import('tailwindcss').Config} */
module.exports = {
content: [
"./resources/**/*.blade.php",
"./resources/**/*.js",
"./resources/**/*.vue",
],
theme: {
extend: {
colors: {
'strong-blue': '#0A0E2F', // Menambahkan warna kustom di dalam extend
},
},
},
plugins: [],
}
