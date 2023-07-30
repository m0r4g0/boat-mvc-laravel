# Boataround coding challenge #

## Introduction ##

This coding challenge helps us to know the way you are thinking and the level of your knowledge

Create a simple Laravel MVC application which allows users to create boat objects and store them in database.

## Requirements ##

Boat object has the following data structure _(all attributes are required)_:

* `name`: name of the boat
* `category`: the value must be one of 'sailing-yacht' or 'motor-boat'
* `slug`: URL friendly representation of boat's name, must be unique across all the boats

1. Prepare Controller CRUD operations and appropriate routing to allow these actions:
   * Create boat:
     * Create a simple html form where user can input boat name and category
     * Display validation errors if any
     * Css styling is not required
   * View specific boat _(html view is not required)_
   * Edit specific boat _(html view is not required)_
   * Delete specific boat
2. Add request validation based on previous requirements
3. Add php test to:
   * Check that 2 boats with the same 'name' can be created
   * Check that validation fails if user submits non-allowed category

## Optional features ##

1. Extend a route which displays a specific boat so it can accept either boat's database ID or boat's slug
2. Make sure that 2 simultaneously working users cannot create same boats in database which would lead to non-uniqueness of 'slug' parameter
3. Add restrictions that only logged in user can create or edit boats _(with unit test)_
4. Add restriction that users can edit only boats which they have created _(with unit test)_

## Delivery ##

Create a fork from this repository and start your work on that fork.
Commit often.
Use proper commit messages.
When all your code is committed and pushed create a pull request to the original repository.

The code will be reviewed and commented.

If you have any questions don't hesitate to ask [peter.matik@dev.boataround.com](mailto:peter.matik@dev.boataround.com)
