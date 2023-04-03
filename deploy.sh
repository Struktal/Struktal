# Compile Minification Tools
echo "Compiling minify-css.c"
gcc -o minicss deployment/minify-css.c
echo "Compiled minify-css.c"
echo "Compiling minify-js.c"
gcc -o minijs deployment/minify-js.c
echo "Compiled minify-js.c"

# Delete old minified Files
echo "Deleting old minified Files"
rm project/htdocs/static/css/style.min.css
rm project/htdocs/static/js/script.min.js
echo "Deleted old minified Files"

# Recursively find all .css and .js Files except those already containing ".min." in the current Directory and minify them
echo "Minifying CSS Files"
find . -name "*.css" ! -name "*.min.*" -exec echo Minifying {} \; -exec ./minicss {} project/htdocs/static/css/style.min.css --append \;
echo "Minified CSS Files"
echo "Minifying JS Files"
find . -name "*.js" ! -name "*.min.*" -exec echo Minifying {} \; -exec ./minijs {} project/htdocs/static/js/script.min.js --append \;
echo "Minified JS Files"

# Delete Minification Tools
echo "Deleting minicss"
rm minicss.exe
echo "Deleted minicss"
echo "Deleting minijs"
rm minijs.exe
echo "Deleted minijs"