## Use Vue.js to implement a note app (SPA).
The application consists of only 2 pages. Main page (Home page), displays a list of all notes. Each note displays a title and a todo list reduced to a few items.. Second page is edit note page allows you to edit a specific note, mark todo list items, and then save the changes.
### Home Page:
Each note has a title and a todo list. Each todo item in the list consists of a checkbox and an associated text label.
### Actions on the home page:
1. Create a new note
2. Change a note
3. Delete a note (requires confirmation)
## Note Page:
### Note Actions:
1. save changes
2. undo editing (needs confirmation)
3. delete (requires confirmation)
4. undo the change
5. redo undone change
### Actions with todo list:
1. add
2. delete
3. mark as done
4. change text
## Backend:
Implement the backend using Laravel for the above frontend App. Utilize RESTful CRUD. There is no need to include the whole Laravel project, include only the files you created for the app. (Controllers/routes/Services and etc)
### Functional requirements:
1. All actions on the app should occur without reloading the page.
2. Confirmation of actions (delete note) is performed using a dialog box.
### Technical requirements:
1. Dialog boxes should be implemented without using "alert", "prompt" and "confirm".
2. You can use JavaScript or TypeScript as the development language.
3. You must use Vite, for development and building.
4. You must use Tailwind for UI, no other UI libraries should be used (for example Vuetify)
5. The application logic should be broken down into a reasonable number of self-contained Vue components.
