# Brightsolid_Project

## Meeting 1 (Monday 26th)
### Members Present:
DJ Dorren, Ethan Rowe, Jamie Fergus

### Members Not Present:
Daniel Jakubek, John Harrow

### Apologies:
n/a

### Summary of Conversation:
During this meeting all members present discussed their skills relevant to the project. 
As it was early in the project and not all members where present nothing further was discussed.


## Meeting 2 (Tuesday 27th)
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



## Meeting 3 Client Meeting 1 (Wednesday 28th)
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

  -the plan is up to you, we advise you to not wait until the third week to write the report. Do 	work now rather than later.  Having a plan that will look ahead to not only Monday but further.  


## Meeting 4 (Monday 28th) - scrum 1

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
	-yesterday I worked on the user stories  
	-went through the briefing got the basic stuff and put that into a user story  
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



## Meeting 5 (Friday 30th) - scrum 2
### Members Present:
DJ Dorren, Ethan Rowe, Jamie Fergus, Daniel Jakubek, John Harrow

### Members Not Present:

### Apologies:
n/a

### Summary of Conversation:
Daniel Jakubek - yesterday I started working on the log ibn system 
- managed to get the compliance manager log in done 
- log in system works need to add a redirect to dashboard
- had some issues with DB connect 
- the database we're using is very simple at the moment so we need to put that into the actual DB
- Plan for today is to make it look like DJ's designs

Jamie -  has there been any hashing yet?

Daniel - yes all paswords are shashed and input compaired using sha256
	- John do you have any issues to add?

John - no issues not mentioned


Jamie - yesterday I worked on creating the DB had a couple issues with some of the Primary keys such as the non compliance table - theres anther table that links but theres not ref
	- we might also need to figure out how to store the timestap variables

Daniel - the thing with the primary keys got updated this morning and with timestamp could we just use the date.

jamie - I'm not sure as it needs to store the date and time including ms which isn't included in timestamp or date.
	we also need to store json and i've just done long blob currently

ethan - So far we have a basic view for what well use for the compliance manager and auditor - were just getting

Jamie - just to add the developmental isn't as up to date as I was working on anthor branch

DJ - I worked with Jamie and Ethan on some pair programming on both the database and the dashboards 
	- I also played around a bit with the styling this morning to see if I could fix a couple styling issues that I will continue to work on today

Daniel - plans for today then?

Ethan - Jamie DJ and I will be working on connecting the database and the queries.

Daniel - Can we use SQLI?

Everyone - Yes
