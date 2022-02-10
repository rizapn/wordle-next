# wordle-next
Provide words that match with wordle clue

Paremeters in the script :
<pre>
  lang=en|id
  max=100
  guess=super...+-
</pre>

lang=en for english words, lang=id for indonesian/bahasa (default)
max is the maximum number of words displayed
guess is the guess and status from wordle
<pre>
  - is for gray / invalid chars
  . is for yellow / valid chars but wrong position
  + is for green / valid chars and its position
</pre>

guess is separated by comma
parameters are separated by &

Example :
<pre>
php katla.php "lang=en&max=100&guess=guest.+-.-"
</pre>
