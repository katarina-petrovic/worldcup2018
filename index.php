<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="robots" content="noindex" />
        <title>Manage Football2018</title>
    </head>
    <body>
        <h1>Manage Football2018</h1>
        <div class="import-data">
            <h3>Import data from json files</h3>
            <form action="import.php" method="POST"> 
                <input type="submit" name="import_data" value="Import data"/>
            </form>
        </div>

        <div class="display-team-data">
            <h3>Display Teams Results</h3>
            <form action="teams_results.php" method="POST">
                <input type="submit" name="display_team_statistics" value="Display Teams Results"/>
            </form>
        </div>
        <div class="display-matches">
            <h3>Display matches ordered by temperature</h3>
            <form action="matches.php" method="POST">
                <input type="submit" name="display_matches" value="Display Matches Sorted By Temperature"/>
            </form>
        </div>

        <div class="display-matches">
            <h3>Delete all data and test again</h3>
            <form action="delete_data.php" method="POST">
                <input type="submit" name="delete_all_data" value="Delete All Data"/>
            </form>
        </div>
    </body>
</html>
