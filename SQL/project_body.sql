create or replace PACKAGE BODY CENG352_PROJECT
AS

---------------------------------------------------------------------------------------------------------------------------

  PROCEDURE login
  (
      p_employee_id  IN INTEGER,
      p_passwd       IN VARCHAR2,
      p_RESULT       OUT CHAR
  )
  IS
    countU INTEGER := 0;
    userType VARCHAR2(30) := '0';
    
  BEGIN
  
    SELECT COUNT(*)
    INTO countU
    FROM Employee E
    WHERE E.employeeID = p_employee_id AND E.passwd = p_passwd;

    p_RESULT := '0';
    
    IF countU > 0 THEN
      SELECT employeeType
      INTO userType
      FROM Employee E
      WHERE E.employeeID = p_employee_id AND E.passwd = p_passwd;
      
      IF userType = 'doctor' THEN
        p_RESULT := '1';
      END IF;
      
      IF userType = 'secretary' THEN
        p_RESULT := '2';
      END IF;
      
      IF userType = 'staff' THEN
        p_RESULT := '3';
      END IF;
      
      IF userType = 'admin' THEN
        p_RESULT := '4';
      END IF;
      
    END IF;  
    
    --dbms_output.put_line(TO_CHAR( p_RESULT ));
  
  END login;  
    
---------------------------------------------------------------------------------------------------------------------------

    
  PROCEDURE remove_employee
  (
      p_employee_id   IN INTEGER,
      p_type          IN VARCHAR2,
      p_RESULT        OUT CHAR
  )
  IS 
  
  BEGIN
  
    IF p_type = 'doctor' THEN
      DELETE FROM Doctor 
      WHERE Doctor.employeeID = p_employee_id;
    
      DELETE FROM Employee
      WHERE Employee.employeeID = p_employee_id;
      
    ELSIF p_type = 'secretary' THEN 
      DELETE FROM Secretary 
      WHERE Secretary.employeeID = p_employee_id;
      
      DELETE FROM Employee
      WHERE Employee.employeeID = p_employee_id;
      
    ELSIF p_type = 'staff' THEN 
      DELETE FROM Staff
      WHERE Staff.employeeID = p_employee_id;
   
      DELETE FROM Employee
      WHERE Employee.employeeID = p_employee_id;    

    ELSE 
      null;
    END IF;
    
    commit;
    
  END remove_employee;  
  
---------------------------------------------------------------------------------------------------------------------------
  
  
  PROCEDURE add_employee
  (
      p_employee_id   IN INTEGER,
      p_passwd        IN VARCHAR2,
      p_type          IN VARCHAR2,
      p_RESULT        OUT CHAR
  )
  
  IS
  
  BEGIN 
  
    insert INTO Employee( employeeID, passwd, employeeType ) 
    values( p_employee_id, p_passwd, p_type );
    
    commit;
    
  END add_employee;
  
---------------------------------------------------------------------------------------------------------------------------
  
  
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
  )
  
  IS
  
  BEGIN 
  
    insert INTO Doctor ( doctorID, employeeID, passwd, dname, dsurname, phone, qualification, salary ) 
    values( p_doctor_id, p_employee_id, p_passwd, p_dname, p_dsurname, p_phone, p_qualification, p_salary );  
    
    commit;
    
  END add_doctor;
  
  ---------------------------------------------------------------------------------------------------------------------------
  
    
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
  )
  
  IS
  
  BEGIN 
    
    UPDATE Doctor D
    SET D.passwd = p_passwd, D.dname = p_dname, D.dsurname = p_dsurname, D.phone = p_phone, D.qualification = p_qualification, D.salary = p_salary
    WHERE D.doctorID = p_doctor_id;
    p_RESULT := 'T';
    
    commit;
    
  END edit_doctor;
  
  ---------------------------------------------------------------------------------------------------------------------------
  
  
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
  )
  
  IS
  
  BEGIN 
  
    insert INTO Secretary ( secretaryID, employeeID, passwd, sname, ssurname, phone, salary ) 
    values( p_secretary_id, p_employee_id, p_passwd, p_sname, p_ssurname, p_phone, p_salary );  
    
    commit;
    
  END add_secretary;
  
  ---------------------------------------------------------------------------------------------------------------------------
    
    
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
  )
  
  IS
  
  BEGIN 
    
    UPDATE Secretary S
    SET S.passwd = p_passwd, S.sname = p_sname, S.ssurname = p_ssurname, S.phone = p_phone, S.salary = p_salary
    WHERE S.secretaryID = p_secretary_id;
    p_RESULT := 'T';
    
    commit;
    
  END edit_secretary;
  
  ---------------------------------------------------------------------------------------------------------------------------
  
  
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
  )
  
  IS
  
  BEGIN 
  
    insert INTO Staff ( staffID, employeeID, passwd, sname, ssurname, phone, salary ) 
    values( p_staff_id, p_employee_id, p_passwd, p_sname, p_ssurname, p_phone, p_salary );  
    
    commit;
    
  END add_staff;
  
  ---------------------------------------------------------------------------------------------------------------------------
    
    
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
  )
  
  IS
  
  BEGIN 
    
    UPDATE Staff S
    SET S.passwd = p_passwd, S.sname = p_sname, S.ssurname = p_ssurname, S.phone = p_phone, S.salary = p_salary
    WHERE S.staffID = p_staff_id;
    p_RESULT := 'T';
    
    commit;
    
  END edit_staff; 
  
  ---------------------------------------------------------------------------------------------------------------------------
 
 
  PROCEDURE set_treatment
  (
      p_record_id     IN INTEGER,
      p_new_treatment IN VARCHAR2,
      p_RESULT        OUT CHAR
  )
  IS
    countR INTEGER := 0;
  
  BEGIN
  
      SELECT COUNT(*)
      INTO countR
      FROM Record R
      WHERE R.recordID = p_record_id;

      IF countR > 0 THEN
        UPDATE Record R
        SET R.treatment = p_new_treatment
        WHERE R.recordID = p_record_id;
        p_RESULT := 'T';
        
      ELSE
        p_RESULT := 'F';
      
      END IF;  
      
      commit;
      
  END set_treatment;
  
---------------------------------------------------------------------------------------------------------------------------


  PROCEDURE end_treatment
  (
      p_record_id     IN INTEGER,
      p_RESULT        OUT CHAR
  )
  IS
    countR INTEGER := 0;
    treatmentType VARCHAR2(30) := '0';
    room_id INTEGER := 0;
    inBed INTEGER := 0;
    ssn_patient VARCHAR2(30);
    
  BEGIN
  
      SELECT COUNT(*)
      INTO countR
      FROM Record R
      WHERE R.recordID = p_record_id;
      
      SELECT SSN
      INTO ssn_patient
      FROM Record R
      WHERE R.recordID = p_record_id;
      
      SELECT COUNT(*)
      INTO inBed
      FROM StaysIn S
      WHERE S.ssn = ssn_patient;
      
      IF countR > 0 THEN
      
        UPDATE Record 
        SET status = 'End', endDate = sysdate
        WHERE recordID = p_record_id;
        
        IF inBed > 0 THEN 
        
          SELECT roomID
          INTO room_id
          FROM StaysIn S
          WHERE S.ssn = ssn_patient;
          
          DELETE FROM StaysIN 
          WHERE ssn = ssn_patient;
    
          UPDATE Room R
          SET R.numberOfPatient = R.numberOfPatient - 1 
          WHERE R.roomID = room_id;

        END IF;
        
        p_RESULT := 'T';
        
      ELSE
        p_RESULT := 'F';
        
      END IF;  
      
      commit;
      
  END end_treatment;

---------------------------------------------------------------------------------------------------------------------------


  PROCEDURE set_status
  (
      p_record_id     IN INTEGER,
      p_new_status    IN VARCHAR2,
      p_RESULT        OUT CHAR
  )
  IS
    countR INTEGER := 0;
    
  BEGIN
    SELECT COUNT(*)
    INTO countR
    FROM Record R
    WHERE R.recordID = p_record_id;

    IF countR > 0 THEN
      UPDATE Record R
      SET R.status = p_new_status
      WHERE R.recordID = p_record_id;

      p_RESULT := 'T';
      
    ELSE
      p_RESULT := 'F';
    
    END IF;  
  
    commit;
  
  END set_status;
  
---------------------------------------------------------------------------------------------------------------------------
  
  
  PROCEDURE show_old_patients
  (
      p_doctor_id     IN INTEGER,
      p_patients      OUT SYS_REFCURSOR
  )

  IS

  BEGIN
  
    OPEN p_patients FOR
    SELECT *
    FROM Record R, Patient P
    WHERE R.ssn = P.ssn and R.doctorID = p_doctor_id AND R.status LIKE 'End';
    
  END show_old_patients;

---------------------------------------------------------------------------------------------------------------------------


  PROCEDURE arrange_room
  (
      p_record_id     IN INTEGER,
      p_ssn           IN VARCHAR2,
      p_RESULT        OUT CHAR
  )
  IS
    countRow INTEGER := 0;
    room_id INTEGER;
    
    refCursorValue SYS_REFCURSOR;
    
    CURSOR c1 IS 
    SELECT * 
    FROM Room R
    WHERE R.numberOfPatient < 2;

    join_rec  c1%ROWTYPE;
  
  BEGIN 
  
    OPEN refCursorValue FOR
    SELECT * 
    FROM Room R
    WHERE R.numberOfPatient < 2;  
    
    LOOP
      FETCH refCursorValue INTO join_rec;
      EXIT WHEN refCursorValue%NOTFOUND;
      countRow := countRow + 1;
      room_id := join_rec.roomID;
      EXIT;
    END LOOP;  
    
    IF countRow > 0 THEN
      INSERT INTO StaysIn( SSN, roomID ) VALUES( p_ssn, room_id  );
      
      UPDATE Room R
      SET R.numberOfPatient = R.numberOfPatient + 1 
      WHERE R.roomID = room_id;
      
      UPDATE Record R
      SET R.roomID = room_id 
      WHERE R.ssn = p_ssn and R.recordID = p_record_id;
      
      p_RESULT := 'T';
     
    ELSE 
      p_RESULT := 'F';
       
    END IF;
     
    commit;
     
  END arrange_room;
  
---------------------------------------------------------------------------------------------------------------------------  
  
  
  PROCEDURE set_doctor
  (
      p_record_id     IN INTEGER,
      p_complaint     IN VARCHAR2,
      p_RESULT        OUT CHAR
  )
  IS
    refCursorValue SYS_REFCURSOR;
    
    doctor_id VARCHAR2(30);
    countRow INTEGER := 0;
    
    CURSOR c1 IS 
    SELECT * 
    FROM Doctor D
    WHERE D.qualification = p_complaint;

    join_rec  c1%ROWTYPE;
    
  BEGIN
    
    OPEN refCursorValue FOR
    SELECT * 
    FROM Doctor D
    WHERE D.qualification = p_complaint;
    
    LOOP
      FETCH refCursorValue INTO join_rec;
      EXIT WHEN refCursorValue%NOTFOUND;
      countRow := countRow + 1;
      doctor_id := join_rec.DoctorID;
      EXIT;
    END LOOP;  
  
    IF countRow > 0 THEN
      UPDATE Record R
      SET R.doctorID = doctor_id
      WHERE R.recordID = p_record_id;
      p_RESULT := 'T';
    
    ELSE
      p_RESULT := 'F';
     
    END IF;  
    
    commit;
    
  END set_doctor;
  
---------------------------------------------------------------------------------------------------------------------------


  PROCEDURE search_records
  (
      p_ssn           IN INTEGER,
      p_records       OUT SYS_REFCURSOR
  )
  IS
  
  BEGIN 
    
    OPEN p_records FOR
    SELECT *
    FROM Record R, Patient P
    WHERE R.ssn = p_ssn and P.ssn = p_ssn;
  
  END search_records;

---------------------------------------------------------------------------------------------------------------------------


  PROCEDURE add_record
  (
      p_ssn           IN VARCHAR2,
      p_complaint     IN VARCHAR2,
      p_RESULT        OUT CHAR
  )
  IS
  
  BEGIN 
  
    insert INTO Record ( SSN, status, complaint, treatment )  
    values( p_ssn, 'New', p_complaint, 'None' );  
    
    commit;
    
  END add_record;
  
---------------------------------------------------------------------------------------------------------------------------  
  
  
  PROCEDURE add_patient
  (
      p_ssn           IN VARCHAR2,
      p_name          IN VARCHAR2,
      p_surname       IN VARCHAR2,
      p_phone         IN VARCHAR2,
      p_address       IN VARCHAR2,
      p_RESULT        OUT CHAR
  )
  IS
    countP INTEGER := 0;
    
  BEGIN 
    
    SELECT COUNT(*)
    INTO countP
    FROM Patient P
    WHERE P.SSN = p_ssn ;
    
    IF countP = 0 THEN  
      insert INTO Patient ( SSN, pname, psurname, phone, address )  
      values( p_ssn, p_name, p_surname, p_phone, p_address );  
      p_RESULT := 'T';
    
    ELSE 
      p_RESULT := 'F';
    END IF;
    
    commit;
    
  END add_patient;
  
---------------------------------------------------------------------------------------------------------------------------
  
  
  PROCEDURE get_employee
  (
      p_employee_id   IN INTEGER,
      p_type          IN VARCHAR2,
      p_employees     OUT SYS_REFCURSOR
  )
  IS

  BEGIN
  
    IF p_type = 'doctor' THEN
      OPEN p_employees FOR
      SELECT *
      FROM  Doctor D
      WHERE D.employeeID = p_employee_id;
    END IF;
    
    IF p_type = 'secretary' THEN
      OPEN p_employees FOR
      SELECT *
      FROM  Secretary S
      WHERE S.employeeID = p_employee_id;
    END IF;
    
    IF p_type = 'staff' THEN
      OPEN p_employees FOR
      SELECT *
      FROM  Staff S
      WHERE S.employeeID = p_employee_id;
    END IF;
  
  END get_employee;
  
---------------------------------------------------------------------------------------------------------------------------
  
  
  PROCEDURE show_employees
  (
      p_type          IN VARCHAR2,
      p_employees     OUT SYS_REFCURSOR
  )
  IS

  BEGIN
  
    IF p_type = 'doctor' THEN
      OPEN p_employees FOR
      SELECT *
      FROM  Doctor D;
    END IF;
    
    IF p_type = 'secretary' THEN
      OPEN p_employees FOR
      SELECT *
      FROM  Secretary S;
    END IF;
    
    IF p_type = 'staff' THEN
      OPEN p_employees FOR
      SELECT *
      FROM  Staff S;
    END IF;
  
  END show_employees;
  
---------------------------------------------------------------------------------------------------------------------------


  PROCEDURE current_patients_records
  (
      p_doctor_id     IN INTEGER,
      p_records       OUT SYS_REFCURSOR
  )
  IS
  
  BEGIN
   
    OPEN p_records FOR
    SELECT *
    FROM Record R, Patient P
    WHERE R.ssn = P.ssn and R.doctorID = p_doctor_id AND R.status NOT LIKE 'End';  
  
  END current_patients_records;

---------------------------------------------------------------------------------------------------------------------------


  PROCEDURE not_confirmed_records
  (
      p_records       OUT SYS_REFCURSOR
  )
  IS
  
  BEGIN
   
    OPEN p_records FOR
    SELECT *
    FROM Record R, Patient P
    WHERE R.ssn = P.ssn  and R.status LIKE '%New%';
    
  END not_confirmed_records;

---------------------------------------------------------------------------------------------------------------------------


  PROCEDURE responsible_rooms
  (
      p_staff_id      IN INTEGER,
      p_rooms         OUT SYS_REFCURSOR
  )
  IS
  
  BEGIN
   
    OPEN p_rooms FOR
    SELECT *
    FROM ResponsibleFor R, Room Ro
    WHERE Ro.roomID = R.roomID and R.staffID = p_staff_id;  
  
  END responsible_rooms;
  
---------------------------------------------------------------------------------------------------------------------------


  PROCEDURE find_unassigned_rooms
  (
      p_rooms         OUT SYS_REFCURSOR
  )
  IS
  
  BEGIN
  
    OPEN p_rooms FOR
    SELECT *
    FROM Room R
    WHERE R.assigned = 0;  
  
  END find_unassigned_rooms;

---------------------------------------------------------------------------------------------------------------------------


  PROCEDURE find_assigned_rooms
  (
      p_rooms         OUT SYS_REFCURSOR
  )
  IS
  
  BEGIN
  
    OPEN p_rooms FOR
    SELECT *
    FROM ResponsibleFor R;
  
  END find_assigned_rooms;

---------------------------------------------------------------------------------------------------------------------------


  PROCEDURE assign_room_staff
  (
      p_room_id       IN INTEGER,
      p_staff_id      IN INTEGER,
      p_RESULT        OUT CHAR
  )
  IS
  
  BEGIN
  
    INSERT INTO ResponsibleFor ( roomID, staffID ) VALUES ( p_room_id, p_staff_id );
    UPDATE Room 
    SET assigned = 1
    WHERE roomID = p_room_id;
    
    commit;
  
  END assign_room_staff;
---------------------------------------------------------------------------------------------------------------------------


  PROCEDURE unassign_room_staff
  (
      p_room_id       IN INTEGER,
      p_staff_id      IN VARCHAR2,
      p_RESULT        OUT CHAR
  )
  IS
  
  BEGIN

    DELETE FROM ResponsibleFor 
    WHERE roomID = p_room_id AND staffID = p_staff_id;
    
    UPDATE Room 
    SET assigned = 0
    WHERE roomID = p_room_id;
    
    commit;
  
  END unassign_room_staff;
  
---------------------------------------------------------------------------------------------------------------------------  
  
  
  END CENG352_PROJECT;
  