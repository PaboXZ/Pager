
LOG:

Joining login files, add priority to db




Login page
-create login code -not complete(redirections, exceptions, error handling)
-create redirections																	-DONE
-add logout option																		-DONE

Add Login Page For Admin
-create login code -not complete(redirections, exceptions, error handling)
-create redirections																	-DONE
-add logout option 																		-DONE


Access - create seperate file with functions
Errors handling
Sorting
Bootstrap integration


------------------------------------------------------------------
STRUCTURE

Index:
-only logging, registration later, same template

Panel:
-Logo at top, redirection to panel on right side link to user settings
-leftbar with active threads and create thread button
-under logo sorting tool, thread info(?)
-Task window
	-color theme for power
	-only title and content(Edit timestamp)
	-popup menu for editing and settings
-create task button: opens in popup

2 Tasks in a row for widescreen, 1 for narrow
hide threads for narrow view



-----------------------------------------------------------------
DATABASE

Tables:

-USER LOGIN DATA
user ID(Primary)/user name/password hash/is admin bool/last active timestamp/user email
//in email field put 'TEMPORARY' for temporary users
-THREAD DATA
Thread ID(Primary)/Owner ID/Thread name/Thread Version
-USER X THREAD DATA
Thread ID(external)/User ID(external)/View power/Is Owner/Edit permission/Delete permission/Maximum task power(0 for no permission)/Set flag to complete permission
-CONTENT DATA
Content ID/Thread ID/User ID/Title/Content/Created Timestamp/Power/Is complete flag/Is Pinned flag/Last edit timestamp


-----------------------------------------------------------------
THOUGHTS

MAKE RULES FOR TEMPORARY USERS
-temporary users have flag TEMPORARY in field email instead of true value
-disable creating threads
-disable control panel



Later maybe add discussion to tasks in pro version
Possible to make owner's view and personal view
Simplified and pro version

For simplified version:

Owner choices at creation menu:
-can users see all or own tasks
-can users edit own tasks
Owner choices at user add menu:
-Can edit own tasks

-----------------------------------------------------------------
TASKS

-CREATE DUMMY USER PANEL
-CREATE TEMPORARY USER FLAG!!!(IMPORTANT) --RESOLVED
-ADD REGISTER OPTION
-REWRITE LOGIN OPTION TO WORK WITH NEW DATABASE LAYOUT --DONE
-CREATE DB STRUCTURE --DONE




-----------------------------------------------------------------
LOG
--0.02

Modified login to work with new DB
Added name/email login option

--0.01

Created db template