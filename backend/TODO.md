# Current To-Do List

This document outlines the current status of tasks.

1.  [completed] Review existing CRUDs based on routes and controllers.
2.  [completed] Identify models with no corresponding CRUD interfaces.
3.  [completed] Consider the user's input about `Study` being a former pivot table.
4.  [completed] Investigate the purpose of the `Has` model if it's unclear.
5.  [completed] Formulate a comprehensive answer to the user about missing CRUDs.
6.  [completed] Delete the `Has` model and controller files.
7.  [completed] Delete the `Study` model and controller files.
8.  [completed] Implement authorization for `UsersController` using Laravel Policies.
9.  [completed] Fix the `Controller.php` base class to include `AuthorizesRequests` trait.
10. [completed] Create and implement the `IsAdmin` middleware.
11. [completed] Register the `IsAdmin` middleware alias in `bootstrap/app.php`.
12. [completed] Refactor `routes/web.php` to group admin CRUD routes under `/dashboard` with `auth` and `admin` middleware.
13. [completed] Update route names in all Blade templates to use the `dashboard.` prefix.
14. [completed] Create a new `home.blade.php` view with the requested content.
15. [completed] Update the root route in `routes/web.php` to return the new `home` view.
16. [completed] Add Subjects link to primary navigation in `layouts/navigation.blade.php`.
17. [completed] Add Subjects link to responsive navigation in `layouts/navigation.blade.php`.
18. [pending] **Messages CRUD (Admin)**
19. [pending] Add admin routes for messages (`index`, `edit`, `update`, `destroy`).
20. [pending] Implement `MessagesController@index()`.
21. [pending] Implement `MessagesController@edit(Message $message)`.
22. [pending] Implement `MessagesController@update(Request $request, Message $message)`.
23. [pending] Implement `MessagesController@destroy(Message $message)`.
24. [pending] Create `resources/views/messages/index.blade.php`.
25. [pending] Create `resources/views/messages/edit.blade.php`.
26. [pending] Add a "Messages" link to the dashboard navigation.