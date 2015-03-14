# cmpe133 - ProConnect
------------------------
How to first setup our repository. Xampp apache and parse are needed.
------------------------
Open up the github application on your computer and click on the gear wheel icon on the upper right.

Open Git Shell.

Navigate to c:/xampp/htdocs

then type: git clone https://github.com/Agevkired/cmpe133.git

this should download everything and place it in c:/xampp/htdocs/cmpe133

you are now ready to go.



Some useful git commands to use with git command line.
------------------------


These commands should be performed every time you start coding again
------------------------
//to download any changes that have been made since then.

git fetch
//Downloads all history from the repository bookmark

git pull
//Downloads bookmark history and incorporates changes



These commands should be performed in sequence to upload any new changes.
------------------------

git fetch
//Downloads all history from the repository bookmark

git status
Lists all new or modified files to be commited

git add -A
//Snapshots the file in preparation for versioning. You can also use 'git add filename', -A snapshots everything

git commit -m "Write update message here"
//Records file snapshots permanently in version history, this attaches a message to the modified files

git push
//Uploads all local branch commits to GitHub
