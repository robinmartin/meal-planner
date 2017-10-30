# Meal Planner

Currently an MVP, this app was built for personal use but it successfully demonstrates some basic (and more advanced) laravel/php/vue skills.

The idea of the app is to create a simple meal planner where a user can determine which meal they are going to be eating on a given day and then set repeat rules. 

Unlike a lot of existing products in the same category this app focuses on simplicity and doing 1 or 2 things well - particularly ease of use. 

Future versions of the app could:

- enable saving of notes against a meal
- create email reminders of what meals are upcoming for a given week
- show a report of most common meal entries over a set time period

Some of the more interesting technology bits:

- The system utilises laravel/passport to create a fully functioning oauth2 server
- All 'meals' when added are saved to a full-text search index - currently using Algolia for this allowing for quick and easy filtering when searching for new meals to add on future dates
- Basic ability to allow repeat meals i.e. the same meal repeating each week on the same day or every 2 weeks
