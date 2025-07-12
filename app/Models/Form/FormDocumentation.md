# User documentation for form models
This file will serve as documentation for the form models.

## models
- Form.php
- FormQuestions.php
- FormResponce.php
- FormQuestionsAnswers.php

### Form.php
database object that holds the properties of the form i.e.
- form id
- competition
- date of close / status
- form questions

### FormQuestions.php
database object that holds the questions associated with a form

### FormResponce.php
database object that holds the properties of a response to a form i.e.
- response id
- competition?
- date of creation
- question answers (content of responce)
- maybe edit history?  (maybe a responce will hold many Q-A's, and display the primary one)

### FormQuestionsAnswers.php
database object that holds the answers to the questions on the form