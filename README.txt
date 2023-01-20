
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

DATABASE STRUCTURE:

Table:
user_data

Values:
user_id -PRIMARY KEY, auto increment
user_email -Set to value TEMPORARY if user is created by thread owner		MAX LENGTH: 64
user_password -Password hash
user_name																	MAX LENGTH: 64
user_is_admin -Values: 0 for not admin, 1 for admin
user_last_active -Timestamp updated after avery single operation(including page refresh)

Table:
thread_data

Values:
thread_id -PRIMARY KEY, auto increment
thread_owner_id 
thread_name																	MAX LENGTH: 64
thread_version -For later use												VALUES: 0-3; 0-Simple, 1-Pro

Table:
task_data

Values:
task_id -PRIMARY KEY, auto increment
task_thread_id -For which thread task was created
task_user_id -Id of author
task_title																	MAX LENGTH: 256
task_content																MAX LENGTH: 2024
task_create_timestamp
task_edit_timestamp -Timestamp of last edit
task_power -Priority of task												VALUES: 0-15
task_is_complete -Values: 0 is not complete, 1 is complete
task_is_pinned -Values: 0 is not pinned, 1 is pinned

Table
connection_user_thread  -table where information about connection to thread and permissions for that thread are stored

Values:

connection_user_id -External user_data key
connection_thread_id -External thread_data key
connection_view_power -Selects which tasks user can browse
connection_is_owner -Values: 0 for not owner 1 for owner
connection_edit_permission -Values: 0 for no permission to edit, 1 for permission
connection_delete_permission -As above
connection_create_power -Up to which priority user can create tasks -0 for no permission to create
connection_complete_permission -Values: 0 cannot change completed flag, 1 can change


-----------------------------------------------------------------
SESSION VALUES

ON LOG IN:
user_name
user_id - main variable to check if user is logged in, also key in database
user_is_admin - flag for admins: 1 is true, 0 is false
user_last_active - timestamp with date of last activity (refresh page counts)
user_temporary_flag - is user account temporary (local for single thread) or regular

ERRORS(remember to clear after shown)
error_create_thread - for unsuccessful thread creation									-not yet in use(need to be called)
error_login - for unsuscessful login													-> index.php

MESSAGE(remember to clear after use)
to do


-----------------------------------------------------------------
INPUT DATA
user_name - alnum 3-20 characters
user_password - 8-48 characters

-----------------------------------------------------------------
THOUGHTS

THINK ABOUT LIMITS

-Threads per user cap
-Tasks per thread cap

REMEMBER ERROR MESSAGES
MAYBE CREATE MESSAGING SYSTEM (one session variable should be enough)

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

-CHANGE TEMPORARY FLAG TO thread_id so when thread is deleted its easier to delete temporary users
-CREATE THREAD PRINT AND SWITCH MODULE
-ADD REGISTER OPTION
-HANDLE ERRORS (create_thread.php)										--DONE
-CREATE LIST OF SESSION VARIABLES										--DONE			
-CREATE CREATE_THREAD PAGE												--DONE
-CREATE DATABASE DOCUMENTATION											--DONE
-CREATE DUMMY USER PANEL												--DONE
-CREATE TEMPORARY USER FLAG!!!(IMPORTANT) 								--RESOLVED
-REWRITE LOGIN OPTION TO WORK WITH NEW DATABASE LAYOUT 					--DONE
-CREATE DB STRUCTURE 													--DONE




-----------------------------------------------------------------
LOG
--0.05

Fixed creating threads
Added thread exception handling

--0.04

Added list of SESSION variables
Completed exceptions in login module

--0.03

Added creating threads module

--0.02

Modified login to work with new DB
Added name/email login option

--0.01

Created db template