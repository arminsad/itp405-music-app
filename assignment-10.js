const express = require("express");
const axios = require("axios");
const fs = require("fs");
const app = express();

app.get("/api/github/:username", (request, response) => {
    const username = request.params.username;
    const filename = `${username}.txt`;

    fs.readFile(filename, "utf8", (error, data) => {
        if (error) {
            axios
                .get((`https://api.github.com/users/${username}`) , {
                    headers: {
                        Accept: "application/json",
                    },
                })
                .then(
                (githubResponse) => {
                    const repos = String(githubResponse.data.public_repos);
                    fs.writeFile(filename, repos, (error) => {
                        console.log("File saved!");
                    });

                    response.json({
                        repoCount: repos,
                    });
                });
            }
            else {
                response.json({
                    repoCount: Number(data),
                });
            }
    });    
});

app.listen(8000);