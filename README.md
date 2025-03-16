### PHP 8.3 + Laravel 12 React Starter Kit

To run this project, just clone it and input `composer run dev` on the command line.

---

This was a technical test consisting of a basic CRUD app for Dinapos Cloud, only working with a single CRUD. Despite this however, the app implements every single functionality a CRUD can have on controller. This includes middleware, seeders, factories, validation, form requests and resources for every possible method, even if checking a single item isn't something that is available. Worth noting is the fact that the controller methods don't return JSON, instead redirecting to other pages instead, since the frontend and backend are so tightly coupled that an AJAX structure isn't really the way to go.

The frontend was built using React 19 + TailwindCSS and Shadcn UI, which really simplified building most of the website, and most components just use some light styling since they look good on their own.
