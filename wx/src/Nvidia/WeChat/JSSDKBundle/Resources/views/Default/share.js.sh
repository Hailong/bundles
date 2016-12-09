#!/bin/sh

#npm install uglify-js -g

uglifyjs ./share.js.src -m -c -o ./share.js.twig

perl -p -i -e 's/TWIG_PLACEHOLDER/{{ config|raw }}/g' ./share.js.twig
