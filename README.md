# wordle-next
Provide words that match with wordle clue

Paremeters in the script :
  lang=en|id
  max=100
  guess=super...+-

lang=en for english words, lang=id for indonesian/bahasa (default)
max is the maximum number of words displayed
guess is the guess and status from wordle
  - is for gray / invalid chars
  . is for yellow / valid chars but wrong position
  + is for green / valid chars and its position

guess is separated by comma
parameters are separated by &

Example :

php wordle.php "lang=en&max=100&guess=guest.+-.-"

