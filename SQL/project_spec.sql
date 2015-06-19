create or replace PACKAGE ceng352_project
AS

  -- Author  : Mustafa - Burak
  -- Created : 30/05/2015 12:06:13 PM
  -- Purpose :  DO NOT EDIT THIS PACKAGE SPECIFICATION!!!
  -- Public function and procedure declarations

  PROCEDURE login
  (
      p_employee_id  IN INTEGER,
      p_passwd       IN VARCHAR2,
      p_RESULT       OUT CHAR
  );
	  
    
  PROCEDURE remove_employee
  (
      p_employee_id   IN INTEGER,
      p_type          IN VARCHAR2,
      p_RESULT        OUT CHAR
  );
	  
    
  PROCEDURE add_employee
  (
      p_employee_id   IN INTEGER,
      p_passwd        IN VARCHAR2,
      p_type          IN VARCHAR2,
      p_RESULT        OUT CHAR
  );
  
  
  PROCEDURE add_doctor
  (
      p_doctor_id     IN INTEGER,
      p_employee_id   IN INTEGER,
      p_passwd        IN VARCHAR2,
      p_dname         IN VARCHAR2,
      p_dsurname      IN VARCHAR2,
      p_phone         IN VARCHAR2,
      p_qualification IN VARCHAR2,
      p_salary        IN INTEGER,
      p_RESULT        OUT CHAR
  );
	  
    
  PROCEDURE edit_doctor
  (
      p_doctor_id     IN INTEGER,
      p_employee_id   IN INTEGER,
      p_passwd        IN VARCHAR2,
      p_dname         IN VARCHAR2,
      p_dsurname      IN VARCHAR2,
      p_phone         IN VARCHAR2,
      p_qualification IN VARCHAR2,
      p_salary        IN INTEGER,
      p_RESULT        OUT CHAR
  );
  
    
  PROCEDURE add_secretary
  (
      p_secretary_id  IN INTEGER,
      p_employee_id   IN INTEGER,
      p_passwd        IN VARCHAR2,
      p_sname         IN VARCHAR2,
      p_ssurname      IN VARCHAR2,
      p_phone         IN VARCHAR2,
      p_salary        IN INTEGER,
      p_RESULT        OUT CHAR
  );
  
  
  PROCEDURE edit_secretary
  (
      p_secretary_id  IN INTEGER,
      p_employee_id   IN INTEGER,
      p_passwd        IN VARCHAR2,
      p_sname         IN VARCHAR2,
      p_ssurname      IN VARCHAR2,
      p_phone         IN VARCHAR2,
      p_salary        IN INTEGER,
      p_RESULT        OUT CHAR
  );
  
  
  PROCEDURE add_staff
  (
      p_staff_id      IN INTEGER,
      p_employee_id   IN INTEGER,
      p_passwd        IN VARCHAR2,
      p_sname         IN VARCHAR2,
      p_ssurname      IN VARCHAR2,
      p_phone         IN VARCHAR2,
      p_salary        IN INTEGER,
      p_RESULT        OUT CHAR
  );
  
  
  PROCEDURE edit_staff
  (
      p_staff_id      IN INTEGER,
      p_employee_id   IN INTEGER,
      p_passwd        IN VARCHAR2,
      p_sname         IN VARCHAR2,
      p_ssurname      IN VARCHAR2,
      p_phone         IN VARCHAR2,
      p_salary        IN INTEGER,
      p_RESULT        OUT CHAR
  );
  
  
  PROCEDURE set_treatment
  (
      p_record_id     IN INTEGER,
      p_new_treatment IN VARCHAR2,
      p_RESULT        OUT CHAR
  );
  
  
  PROCEDURE end_treatment
  (
      p_record_id     IN INTEGER,
      p_RESULT        OUT CHAR
  );
  
  
  PROCEDURE set_status
  (
      p_record_id     IN INTEGER,
      p_new_status    IN VARCHAR2,
      p_RESULT        OUT CHAR
  );
  
  
  PROCEDURE show_old_patients
  (
      p_doctor_id     IN INTEGER,
      p_patients      OUT SYS_REFCURSOR
  );


  PROCEDURE arrange_room
  (
      p_record_id     IN INTEGER,
      p_ssn           IN VARCHAR2,
      p_RESULT        OUT CHAR
  );
  
  
  PROCEDURE set_doctor
  (
      p_record_id     IN INTEGER,
      p_complaint     IN VARCHAR2,
      p_RESULT        OUT CHAR
  );
  
  
  PROCEDURE search_records
  (
      p_ssn           IN INTEGER,
      p_records       OUT SYS_REFCURSOR
  );


  PROCEDURE add_record
  (
      p_ssn           IN VARCHAR2,
      p_complaint     IN VARCHAR2,
      p_RESULT        OUT CHAR
  );
  
  
  PROCEDURE add_patient
  (
      p_ssn           IN VARCHAR2,
      p_name          IN VARCHAR2,
      p_surname       IN VARCHAR2,
      p_phone         IN VARCHAR2,
      p_address       IN VARCHAR2,
      p_RESULT        OUT CHAR
  );
  
  
  PROCEDURE get_employee
  (
      p_employee_id   IN INTEGER,
      p_type          IN VARCHAR2,
      p_employees     OUT SYS_REFCURSOR
  );
  
  
  PROCEDURE show_employees
  (
      p_type          IN VARCHAR2,
      p_employees     OUT SYS_REFCURSOR
  );
  
  
  PROCEDURE current_patients_records
  (
      p_doctor_id     IN INTEGER,
      p_records       OUT SYS_REFCURSOR
  );
  
  
  PROCEDURE not_confirmed_records
  (
      p_records       OUT SYS_REFCURSOR
  );
  
  
  PROCEDURE responsible_rooms
  (
      p_staff_id      IN INTEGER,
      p_rooms         OUT SYS_REFCURSOR
  );
  
  
  PROCEDURE find_unassigned_rooms
  (
      p_rooms         OUT SYS_REFCURSOR
  );
  
  
  PROCEDURE find_assigned_rooms
  (
      p_rooms         OUT SYS_REFCURSOR
  );
  
  
  PROCEDURE assign_room_staff
  (
      p_room_id       IN INTEGER,
      p_staff_id      IN INTEGER,
      p_RESULT        OUT CHAR
  );
  
  
  PROCEDURE unassign_room_staff
  (
      p_room_id       IN INTEGER,
      p_staff_id      IN VARCHAR2,
      p_RESULT        OUT CHAR
  );
  
      
END ceng352_project;