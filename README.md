# Brightsolid_Project

## Meeting (26th Sept)
### Members Present:
DJ Dorren, Ethan Rowe, Jamie Fergus

### Members Not Present:
Daniel Jakubek, John Harrow

### Apologies:
n/a

### Summary of Conversation:
During this meeting all members present discussed their skills relevant to the project. 
As it was early in the project and not all members where present nothing further was discussed.


## Meeting (27th Sept)
### Members Present:
DJ Dorren, Ethan Rowe, Jamie Fergus, Daniel Jakubek, John Harrow

### Members Not Present:
n/a

### Apologies:
n/a

### Summary of Conversation:
Daniel Jakubek raised an issue on if we're designing the application with mobile or desktop in mind first.
The group decided that we would design with desktop first and but as we have decided to use bootstrap the scalability with be checked regularly with mobile / tablet

Jamie Fergus raised an issue about the page refreshing after update and what happens with multiple editors changing data - will there be data racing / locking involved.

The group then decided what we would be doing before the client meeting on Wednesday 28th.

DJ 
  - Basic UX designs to show client tomorrow.

Ethan
  - Start doing user stories.

Jamie
  - Start doing user stories.

Daniel
  - Breaking down user stories into front end / back end tasks

John
  - Breaking down user stories into front end / back end tasks



## Meeting Client Meeting 1 (28th Sept)
### Members Present:
DJ Dorren, Ethan Rowe, Jamie Fergus, Daniel Jakubek

### Members Not Present:
John Harrow

### Apologies:
John Harrow was unable to attend the meeting as his train got cancelled. 

### Summary of Conversation:
Brian: 

Having notes early on will allow you to talk about this in the reports. 

For meeting on Monday, you have 20 min so you can show what you have including GitHub, how you’ve planned the project and prioritised user stories and any questions. 

Any issues should be addressed internally but we are here if anything needs to be addressed.  

Time is crucial so the leader will have to monitor peoples progress and then update us during the leader meetings. 

Ethan: 
  - So far I've been working on converting the brief into the user stories and tasks with Jamie. 

DJ: 
	- Yesterday I worked on the start of the UX designs – we decided to use bootstrap so this 		should convert between tablet computer and phone easily so long as we keep it in mind.  

Jamie: Q? 
	-Worried about the amount of work we must do. 

Brain:A 

- The plan is up to you, we advise you to not wait until the third week to write the report. Do 	work now rather than later.  Having a plan that will look ahead to not only Monday but further.  


## Meeting (28th Sept)

### Members Present: 

DJ Dorren, Ethan Rowe, Jamie Fergus, Daniel Jakubek, John Harrow(virtually) 

  

### Members Not Present: 

n/a 

  

### Apologies: 

 John Harrow was unable to attend the meeting in person as his train got cancelled. 

 

### Summary of Conversation: 

DJ Dorren, Ethan Rowe, Jamie Fergus, Daniel Jakubek, John Harrow(virtually) 

 

Daniel (scrum master) 
- yesterday I worked on putting the user stories onto the GitHub in the correct format and 	adding the definition of done. 

Ethan  
- Yesterday I worked on the user stories  
- Went through the briefing got the basic stuff and put that into a user story  
- I also went over the questions and answers and made some more user stories from them 

Jamie 
-yesterday I worked on the user stories with Ethan as he has talked about. 

John  
 -  worked on the user stories  

 

DJ  
- I’ve been working on the UX designs for mobile phones as I believe these will be the most 	restrictive as we have a lot of info to fit onto the small device screen.  


Daniel 
- did anyone have any issues or problems so far  

Everyone  
- no  

Jamie 
- do we need user stories for the back end? 

Daniel 
- I don’t think so as but if the tasks build up it might be worth turning them into their own 
- next, what are our plans for today? 

 

Group talked about the best way for us to carry out risk assessment and Moscow of the user stories. The group decided to split the project into multiple sprints. 



## Meeting (30th Sept)
### Members Present:
DJ Dorren, Ethan Rowe, Jamie Fergus, Daniel Jakubek, John Harrow

### Members Not Present:

### Apologies:
n/a

### Summary of Conversation:
Daniel Jakubek 
- yesterday I started working on the log ibn system 
- managed to get the compliance manager log in done 
- login system works need to add a redirect to dashboard
- had some issues with DB connect 
- the database we're using is very simple at the moment so we need to put that into the actual DB
- Plan for today is to make it look like DJ's designs

Jamie 
-  has there been any hashing yet?

Daniel 
- yes all passwords are hashed and input compared using sha256
- John, do you have any issues to add?

John 
- no issues not mentioned


Jamie 
- yesterday I worked on creating the DB had a couple issues with some of the Primary keys such as the non compliance table - there's another table that links but there's not ref
- we might also need to figure out how to store the timestamp variables

Daniel 
- the thing with the primary keys got updated this morning and with timestamp could we just use the date.

jamie 
- I'm not sure as it needs to store the date and time including ms which isn't included in timestamp or date.
we also need to store json and i've just done long blob currently

ethan 
- So far we have a basic view for what well use for the compliance manager and auditor - were just getting

Jamie 
- just to add the developmental isn't as up to date as I was working on another branch

DJ 
- I worked with Jamie and Ethan on some pair programming on both the database and the dashboards 
- I also played around a bit with the styling this morning to see if I could fix a couple styling issues that I will continue to work on today

Daniel 
- plans for today then?

Ethan 
- we'll [Jamie DJ Ethan] will be working on connecting the database and the queries.

## Meeting (5th oct)
### Members Present:
DJ Dorren, Ethan Rowe, Jamie Fergus, Daniel Jakubek, John Harrow

### Members Not Present:
n/a

### Apologies:
n/a

### Summary of Conversation:

Daniel 
- I worked on creating the exceptions yesterday we got everything from the database and the deletion
- Right now it doesn't get the rule ID and resource ID automanticxally to make the exception
- Goal for today is just to make it look nice

John 
- Thats what we got done yesterday nothing to add

Jamie 
- Yesterday DJ and I where working on the dashboard
- Added a button on the table in the dashboard that opens an offCanvas
- We where helping John and Ethan with some database issues
- Ethan we might need to talk to you about the dashboard as we where thinking about redesigning it
- Currently we're showing what is basiclly the detailed view on the dashboard.
- Would be good to run you [Ethan] through what we've done.

DJ	
- Plans for today, just making sure everyones on the same page as the brief is quite ambiguous
- then continuing what we where doing yesterday with the detailed view

Ethan	
- Was working on the SQL statements localy for story 12 as it's a big one
- I do need to wait for you guys to be done with the front end.

Jamie	
- As we're changing some stuff in the database we should probably come together today so we're all working on the same thing

Daniel	
- I did add the new CSV files to the github on the branch we're working on so we'll push that to the dev branch soon.

Jamie 	
- I'd also like to change the database out of my name aswell.
	

## Meeting (6th Oct)
### Members Present:
DJ Dorren, Ethan Rowe, Jamie Fergus, Daniel Jakubek, John Harrow

### Members Not Present:
n/a

### Apologies:
n/a

### Summary of Conversation:
Daniel & John  
- Yesteray working with john again on the exception edit.
- Unfortunatly we had some issues with the exception data and tables so we didn't manage to get that done.
- Put some issues in the ask a client channel.
- Plan for today is to get the edit / update exceptions button done might depend on the answer for the client.	
- Issues from yesterday: the review date formatting is wrong becasue of the timezone.

Ethan	
- Yesterday was mostly working opn the SQL and making sure they're working.
- Was inbetween both groups and helping you huys out.
- The last SQL statement I gave you should be working not found any errors in testing.
- Today I will be working on the getting my HTML sorted for suspending exceptions.

Jamie & DJ
- We'll create a pull request for our detailed review page so that can get built upon and you guys can review it.
- Yesterday we where working on the detailed view and some of the dashboard.
- Today we might have a look at some of the charts on the dashboard.
- We had some issues with the CSS of the offCanvas but we can look at that again today.


## Meeting (7th Oct)
### Members Present:
DJ Dorren, Ethan Rowe, Jamie Fergus, Daniel Jakubek, John Harrow

### Members Not Present:
n/a

### Apologies:
n/a

### Summary of Conversation:
John & Daniel
- Creating the exception button and the update exception
- Linked the login with the dashboard
- Had some issues with the SQL on the detailed view updating the compliance status so might need to rewrite that.

DJ & Jamie
- Yesterday we coninued working on the dashboard and the detailed report
- Moved the tables into an acordian drop down
- Updated the exception and resource table to show the user who made changes
- Ran into some issues with the collapsable tables but sorted now
- Adding in the compliance %

Ethan
- Yesterday I was trying to get modals working had some issues but got them working now
- No other issues
	
## Meeting (8th Oct)
### Members Present:
DJ Dorren, Ethan Rowe, Jamie Fergus, Daniel Jakubek, John Harrow

### Members Not Present:
n/a

### Apologies:
n/a

### Summary of Conversation:
Daniel & John
- Yesterday john and I worked on the formating.
- Fixed the data so now the date formatting is correct.
- Fixed the way we create exceptions by changing the SQL statement so now that works.
- Added the log out button but doesn't look pretty but that will be with the final version. 
- Plans for today is writting stuff for the report and combining our stuff with Jamie and DJ's newest version.
- Didn't have any issues yesterday

DJ & Jamie
- Yesterday we continued work on the dashboard.
- We added the compliance status % on the dashboard.
- We also changed the exception table so it has a less unnessesery data.
- Also changed the exception table if there's no exceptions so it doesn't display a table.
- Had some issues with the styling for mobile that we'll continue working on.

Ethan 
- Currently working on the suspending exceptions
- Not much else and no problems / road blocks


## Meeting (9th Oct)
### Members Present:
DJ Dorren, Ethan Rowe, Jamie Fergus, Daniel Jakubek, John Harrow

### Members Not Present:
n/a

### Apologies:
n/a

### Summary of Conversation:
Daniel
- Yesterday I had to wait for stuff to get merged but after that we got everything combined so we have a management and audit different pages all ready to demonstrate tomorrow.
- Added functions to the managerDashboard.php to make code more readable
- No issues really
- Plans for today is putting everything on silvia and writing the report introduction 

Jamie
-  Worked on the readability of the code for a bit after yesterday's scrum with DJ
-  Merging the dashboards and started report writing
-  Continuing with this today.

DJ
- Worked with Jamie on code readability for a bit 
- This morning will continue with report work and making a presentation for tomorrow

Ethan 
- Didn’t get up to much yesterday 
- Reviewed Jamie's pull request 
- Today plans are to combine my exception stuff so it’s ready for tomorrow and report writing

John
- Did the merge request from Jamie yesterday and started working on my section of the report
- Today I will be continuing the report work and working with Ethan and Daniel on merging Ethans work.


## Meeting with Client 2 (10th Oct) 

### Members Present: 

DJ Dorren, Ethan Rowe, Jamie Fergus, John Harrow 

  

### Members Not Present: 

Daniel Jakubek 

### Apologies: 

Daniel Jakubek was unable to join as he has an ear infection 

 

### Summary of Conversation: 

Ethan  

- Daneil is missing as he has an ear infection so he couldn’t make it in this morning. 

- Today’s agenda is just going to be our product backlog a demonstration of the product and questions. 

- Our main goal today is just to have you [client] see the product and get some feedback. 

[Displaying product] 

We're having some issues with the mobile view as there’s so much data. 

 

Client  

- There’s a lot there but as a user I can easily navigate that. 

- Could fix this by having a shorter description or something similar. 

- Have you thought about create customer? 

 

Ethan 

- We had some issues with the structure and understanding of that could you clarify. 

 

Client 

- Brightsolid is a customer and also an admin of the platform. 

- We serve cloud foundations to multiple customers. 

- Customers are businesses and they have users, and the admin is someone at brightsolid who can manage and create customers and users – the customers can’t do this themselves. 

 

DJ 

- How would you like the charts to work? 

 

Client 

- There are two or three things. 

- Simple pie chart that shows the non-compliant and compliant. 

- Seeing if there's any exceptions past due. 

- Also, what exceptions are coming up for review. 

- All this would be good on the dashboard. 

 

 

Client suggestions 

- Short descriptions. 

- Pie charts on dashboard. 

- On the dashboard are there any exceptions that are past due. 

- What exceptions are coming up to review in the next 30-90 days. 

- One of the other things could be a filter or a search on the tables (stretch). 

- For the dashboard you might like to show the total number of exceptions. 

- Non-compliant fields in table could have a red background to make it jump out. 

- Showing the number of exceptions on the dashboard. 
