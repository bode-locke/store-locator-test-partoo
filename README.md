Setup:

- Clone this repository (don't fork it).
- Run `./build` (you need Docker and Docker Compose installed on your machine).
- You can use `./art` to run Artisan commands:
    - `./art key:generate`
    - `./art storage:link`
    - `./art migrate --seed`
- Add the Vite server URL to the .env file : 
     - `VITE_DEV_SERVER_URL=http://localhost:5173`
- Build assets : 
    - `npm install`
    - `npm run dev`

- Once the app is running, the website is available on [http://localhost/](http://localhost/).

When you've finished the exercise, push your work to a private repository on GitHub and share it with [@dbuton](https://github.com/dbuton).
    