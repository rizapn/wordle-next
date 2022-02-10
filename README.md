# wordle-next
Provide words that match with wordle clue

Paremeters in the script :
<pre>
  lang=en|id
  max=100
  guess=super...+-
</pre>

lang=en for english words, lang=id for indonesian/bahasa (default)<br>
max is the maximum number of words displayed<br>
guess is the guess and status from wordle<br>
<pre>
  - is for gray / invalid chars
  . is for yellow / valid chars but wrong position
  + is for green / valid chars and its position
</pre>

guess is separated by comma<br>
parameters are separated by &<br>

Example :
<pre>
php katla.php "max=100&lang=en&g=guest.+-.-,sugar.++--"
</pre>
