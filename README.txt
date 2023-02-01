SKIPPIT

Errors handling
Sorting
Bootstrap integration


------------------------------------------------------------------
STRUCTURE

USER PERMISSIONS AROUND TASKS:

OWNER:
-view
-edit
-flag
-delete

USER:






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

For thread owners display settings

For temporary users don't show threads menu, no need

-----------------------------------------------------------------
DATABASE

DATABASE STRUCTURE:

Table:
user_data

Values:
user_id																						INT, AUTO INC, PRIMARY
user_email																					VARCHAR, 64			REQUIRED (thread id for temporary)
user_password -Password hash																VARCHAR, 256		REQUIRED
user_name																					VARCHAR, 64			REQUIRED
user_is_admin -VALUES: 0 for not admin, 1 for admin											TINYINT, 1			DEFAULT: 0, AUTO
user_last_active -Timestamp updated after avery single operation(including page refresh)	TIMESTAMP			DEFAULT: current timestamp, AUTO

Table:
thread_data

Values:
thread_id 																					INT, AUTO INC, PRIMARY
thread_owner_id 																			INT					REQUIRED
thread_name																					VARCHAR, 32			REQUIRED, (rules: 3-24)
thread_version -VALUES: 0-3; 0-Simple, 1-Pro												INT, 2				DEFAULT: 0, REQUIRED

Table:
task_data

Values:
task_id -PRIMARY KEY, auto increment														INT, AUTO INC, PRIMARY
task_thread_id -For which thread task was created											INT					AUTO
task_user_id -Id of author																	INT					AUTO
task_title																					VARCHAR, 127		REQUIRED (rules: 3-64)
task_content																				VARCHAR. 2024		REQUIRED (rules: 2024 after htmlentities, said to be 1900)
task_create_timestamp																		TIMESTAMP			DEFAULT: current timestamp, AUTO
task_edit_timestamp -Timestamp of last edit													TIMESTAMP			DEFAULT: current timestamp, REQUIRED on edit
task_power -Values 1-5																		INT, 4				DEFAULT: 1, REQUIRED
task_is_complete -Values: 0 is not complete, 1 is complete									TINYINT, 1 			DEFAULT: 0, REQUIRED when called
task_is_pinned -Values: 0 is not pinned, 1 is pinned										TINYINT, 1			DEFAULT: 0, REQUIRED when called

Table
connection_user_thread  -table where information about connection to thread and permissions for that thread are stored

Values:

connection_user_id -External user_data key													INT 				REQUIRED
connection_thread_id -External thread_data key												INT 				REQUIRED
connection_view_power -Selects which tasks user can browse									INT, 4				REQUIRED, DEFAULT: 5
connection_is_owner -Values: 0 for not owner 1 for owner									TINYINT, 1			DEFAULT: 0
connection_edit_permission -Values: 0 for no permission to edit tasks, 1 for permission		TINYINT, 1			DEFAULT: 0
connection_delete_permission -As above														TINYINY, 1			DEFAULT: 0
connection_create_power -Up to which priority user can create tasks -0 for no permission	INT, 4				DEFAULT: 0
connection_complete_permission -Values: 0 cannot change completed flag, 1 can change		TINYINT, 1			DEFAULT: 0


-----------------------------------------------------------------
SESSION VALUES

ON LOG IN:
user_name
user_id - main variable to check if user is logged in, also key in database
user_is_admin - flag for admins: 1 is true, 0 is false
user_last_active - timestamp with date of last activity (refresh page counts)
user_temporary_flag - is user account temporary (local for single thread) or regular
user_active_thread - stores id of an active thread

ERRORS(remember to clear after shown)
error_create_thread - for unsuccessful thread creation									-> panel.php
error_login - for unsuscessful login													-> index.php
error_change_active_thread -unsuccessful thread change									-> panel.php
error_register																			-> index.php

MESSAGE(remember to clear after use)
to do


-----------------------------------------------------------------
INPUT DATA

user_name - alnum 3-20 characters
user_password - 8-48 characters

thread_name - alnum 1-24 characters

-----------------------------------------------------------------
THOUGHTS

IMAGE FOR THREAD (max.1)
THINK ABOUT LIMITS

-Threads per user cap
-Tasks per thread cap

REMEMBER ERROR MESSAGES
MAYBE CREATE MESSAGING SYSTEM (one session variable should be enough)

MAKE RULES FOR TEMPORARY USERS
-temporary users have flag TEMPORARY in field email instead of true value
-disable creating threads
-disable control panel
-to create temporary user use register form with flag



Later maybe add discussion to tasks in pro version
Possible to make owner's view and personal view
Simplified and pro version

For simplified version:

Owner choices at creation menu:
-can users see all or own tasks
-can users edit own tasks
Owner choices at user add menu:
-Can edit own tasks

PANEL

OWNER/USER/TEMPORARY USER

OWNER VIEW:

threads, tasks, settings

USER VIEW:

threads, tasks

TEMPORARY USER VIEW:

tasks


-----------------------------------------------------------------
TASKS

-ADD DUE TO TIME AND DEPEDENCY
-RETHINK STRUCTURE: VIEWS(personal, owners - plus sorting)
-TO RESOLVE: CREATE 3 PANELS WITH CHECK BEFORE OR 1 PANEL WITH CHECK WITHIN
-CREATE TEMPLATE
-FIX HTML ENTITIES string length(double-check strlen)
-ADD TIMESTAMP ON EDIT FUNCTION
-ADD RECAPTCHA TO REGISTER FORM
-CHANGE TEMPORARY FLAG TO thread_id so when thread is deleted its easier to delete temporary users
-CHECK VARIABLES, REVIEW CODE AND DOCUMENTATION


-HIDE ADD TASK BUTTON IF NO ACTIVE THREAD								--DONE
-ADD BOOTSTRAP 															--DONE
-ADD TASK CREATION MODULE 												--DONE
-ADD REGISTER OPTION													--DONE
-CREATE THREAD PRINT AND SWITCH MODULE									--DONE
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
--0.10

Added thread creation, logout link to layout, page somewhat functional

--0.09

Started creating layout
Basic bootstrap integration

--0.08

Completed create_task module
Added task printing to panel

--0.07

Added registeration option

--0.06

Added switch active thread module

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