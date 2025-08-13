module.exports = {
  proxy: 'http://localhost:10004',
  files: [
    './*.php',
    './inc/**/*.php',
    './template-parts/**/*.php',
    './css/**/*.css',
    './js/**/*.js'
  ],
  open: false,
  notify: false
};
