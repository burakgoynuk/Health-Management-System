
/*

--drop table Employee;

CREATE TABLE Employee
(
  employeeID NUMBER,
  passwd VARCHAR2(30) 
    CONSTRAINT epasswd_not_null NOT NULL, 
  employeeType VARCHAR2(10)
    CONSTRAINT employee_type_not_null NOT NULL,
    
  CONSTRAINT employee_pk PRIMARY KEY (employeeID)
);


--drop table Doctor;

CREATE TABLE Doctor
(
  doctorID NUMBER,
  employeeID NUMBER,
  passwd VARCHAR2(30) 
    CONSTRAINT dpasswd_not_null NOT NULL,
  dname VARCHAR2(30)
    CONSTRAINT dname_not_null NOT NULL,
  dsurname VARCHAR2(30)
    CONSTRAINT dsurname_not_null NOT NULL,
  phone VARCHAR2(20) 
    CONSTRAINT dphone_not_null NOT NULL
    CONSTRAINT dphone_unique UNIQUE,
  qualification VARCHAR2(30) 
    CONSTRAINT qualification_not_null NOT NULL,
  salary NUMBER
    CONSTRAINT dsalary_not_null NOT NULL,
    
  CONSTRAINT doctor_pk PRIMARY KEY (doctorID),
  CONSTRAINT doctor_fk FOREIGN KEY (employeeID) REFERENCES Employee(employeeID) ON DELETE CASCADE
);


--drop table Secretary;

CREATE TABLE Secretary
(
  secretaryID NUMBER,
  employeeID NUMBER,
  passwd VARCHAR2(30) 
    CONSTRAINT sec_passwd_not_null NOT NULL,
  sname VARCHAR2(30)
    CONSTRAINT sec_name_not_null NOT NULL,
  ssurname VARCHAR2(30)
    CONSTRAINT sec_surname_not_null NOT NULL,
  phone VARCHAR2(20)
    CONSTRAINT sec_phone_not_null NOT NULL
    CONSTRAINT sec_phone_unique UNIQUE,
  salary NUMBER
    CONSTRAINT sec_salary_not_null NOT NULL,
    
  CONSTRAINT secretary_pk PRIMARY KEY (secretaryID),
  CONSTRAINT secretary_fk FOREIGN KEY (employeeID) REFERENCES Employee(employeeID) ON DELETE CASCADE
);


--drop table Staff;

CREATE TABLE Staff
(
  staffID NUMBER,
  employeeID NUMBER,
  passwd VARCHAR2(30) 
    CONSTRAINT st_passwd_not_null NOT NULL,
  sname VARCHAR2(30)
    CONSTRAINT st_name_not_null NOT NULL,
  ssurname VARCHAR2(30)
    CONSTRAINT st_surname_not_null NOT NULL,
  phone VARCHAR2(20)
    CONSTRAINT st_phone_not_null NOT NULL
    CONSTRAINT st_phone_unique UNIQUE,
  salary NUMBER
    CONSTRAINT st_salary_not_null NOT NULL,
    
  CONSTRAINT staff_pk PRIMARY KEY (staffID),
  CONSTRAINT staff_fk FOREIGN KEY (employeeID) REFERENCES Employee(employeeID) ON DELETE CASCADE
);


--drop table Patient;

CREATE TABLE Patient
(
  SSN VARCHAR2(30),
  pname VARCHAR2(30)
    CONSTRAINT pname_not_null NOT NULL,
  psurname VARCHAR2(30)
    CONSTRAINT psurname_not_null NOT NULL,
  phone VARCHAR2(20)
    CONSTRAINT pphone_not_null NOT NULL
    CONSTRAINT pphone_unique UNIQUE,
  address VARCHAR2(50),
    
  CONSTRAINT patient_pk PRIMARY KEY (SSN)
);


drop table Room;

CREATE TABLE Room
(
  roomID NUMBER,
  rname VARCHAR2(30)
    CONSTRAINT rname_not_null NOT NULL
    CONSTRAINT rname_unique UNIQUE,
  numberOfPatient NUMBER,
  assigned NUMBER,
    
  CONSTRAINT room_pk PRIMARY KEY (roomID)
);


drop table Record;

CREATE TABLE Record
(
  recordID NUMBER,
  SSN VARCHAR2(30),
  doctorID NUMBER,
  status VARCHAR2(30),
  complaint VARCHAR2(30),
  treatment VARCHAR2(30),
  roomID NUMBER,
  startDate DATE DEFAULT sysdate
    CONSTRAINT startDate_not_null NOT NULL,
  endDate DATE,

  CONSTRAINT record_pk PRIMARY KEY (recordID),
  CONSTRAINT record_fk1 FOREIGN KEY (SSN) REFERENCES Patient(SSN) ON DELETE CASCADE,
  CONSTRAINT record_fk2 FOREIGN KEY (doctorID) REFERENCES Doctor(doctorID) ON DELETE CASCADE,
  CONSTRAINT record_fk3 FOREIGN KEY (roomID) REFERENCES Room(roomID) ON DELETE CASCADE
);


drop table ResponsibleFor;

CREATE TABLE ResponsibleFor
(
  roomID NUMBER,
  staffID NUMBER,
    
  CONSTRAINT responsible_pk PRIMARY KEY (roomID, staffID),
  CONSTRAINT responsible_fk1 FOREIGN KEY (roomID) REFERENCES Room(roomID) ON DELETE CASCADE,
  CONSTRAINT responsible_fk2 FOREIGN KEY (staffID) REFERENCES Staff(staffID) ON DELETE CASCADE
);


drop table StaysIn;

CREATE TABLE StaysIn
(
  SSN VARCHAR2(30),
  roomID NUMBER,
    
  CONSTRAINT stays_pk PRIMARY KEY (SSN),
  CONSTRAINT stays_fk1 FOREIGN KEY (roomID) REFERENCES Room(roomID) ON DELETE CASCADE,
  CONSTRAINT stays_fk2 FOREIGN KEY (SSN) REFERENCES Patient(SSN) ON DELETE CASCADE
);

*/



/*
--drop sequence recordID_sequence;

CREATE SEQUENCE recordID_sequence
  START WITH 1
  INCREMENT BY 1
  CACHE 100;


--drop sequence recordID_trigger;

CREATE OR REPLACE TRIGGER recordID_trigger
  BEFORE INSERT ON Record
    FOR EACH ROW
    BEGIN
      SELECT recordID_sequence.nextval
        INTO :NEW.recordID
        FROM dual;
    END;


--drop trigger doc_phoneNumberTrigger;

CREATE OR REPLACE TRIGGER doc_phoneNumberTrigger 
  BEFORE INSERT ON Doctor
    FOR EACH ROW
      DECLARE
        newPhone varchar2(13);	
      BEGIN
        IF (LENGTH( :NEW.phone ) < 10) THEN    
          ROLLBACK;
        END IF;
    
        IF (LENGTH( :NEW.phone ) = 10) THEN    
          newPhone := '+90' || :NEW.phone;
        END IF;
       
        IF (LENGTH( :NEW.phone ) = 11) THEN    
          newPhone := '+9' || :NEW.phone;
        END IF;
        
        IF (LENGTH( :NEW.phone ) = 12) THEN    
          newPhone := '+' || :NEW.phone;
        END IF;
       
        IF (LENGTH( :NEW.phone ) = 13) THEN    
          newPhone := :NEW.phone;
        END IF;
        
        IF (LENGTH( :NEW.phone ) > 13) THEN    
          ROLLBACK;
        END IF;
        
        :NEW.phone := newPhone;			
    END;


--drop trigger sec_phoneNumberTrigger;

CREATE OR REPLACE TRIGGER sec_phoneNumberTrigger 
  BEFORE INSERT ON Secretary
    FOR EACH ROW
      DECLARE
        newPhone varchar2(13);	
      BEGIN
        IF (LENGTH( :NEW.phone ) < 10) THEN    
          ROLLBACK;
        END IF;
    
        IF (LENGTH( :NEW.phone ) = 10) THEN    
          newPhone := '+90' || :NEW.phone;
        END IF;
       
        IF (LENGTH( :NEW.phone ) = 11) THEN    
          newPhone := '+9' || :NEW.phone;
        END IF;
        
        IF (LENGTH( :NEW.phone ) = 12) THEN    
          newPhone := '+' || :NEW.phone;
        END IF;
       
        IF (LENGTH( :NEW.phone ) = 13) THEN    
          newPhone := :NEW.phone;
        END IF;
        
        IF (LENGTH( :NEW.phone ) > 13) THEN    
          ROLLBACK;
        END IF;
        
        :NEW.phone := newPhone;			
    END;


--drop trigger st_phoneNumberTrigger;

CREATE OR REPLACE TRIGGER st_phoneNumberTrigger 
  BEFORE INSERT ON Staff
    FOR EACH ROW
      DECLARE
        newPhone varchar2(13);	
      BEGIN
        IF (LENGTH( :NEW.phone ) < 10) THEN    
          ROLLBACK;
        END IF;
    
        IF (LENGTH( :NEW.phone ) = 10) THEN    
          newPhone := '+90' || :NEW.phone;
        END IF;
       
        IF (LENGTH( :NEW.phone ) = 11) THEN    
          newPhone := '+9' || :NEW.phone;
        END IF;
        
        IF (LENGTH( :NEW.phone ) = 12) THEN    
          newPhone := '+' || :NEW.phone;
        END IF;
       
        IF (LENGTH( :NEW.phone ) = 13) THEN    
          newPhone := :NEW.phone;
        END IF;
        
        IF (LENGTH( :NEW.phone ) > 13) THEN    
          ROLLBACK;
        END IF;
        
        :NEW.phone := newPhone;			
    END;


--drop trigger pat_phoneNumberTrigger;

CREATE OR REPLACE TRIGGER pat_phoneNumberTrigger 
  BEFORE INSERT ON Patient
    FOR EACH ROW
      DECLARE
        newPhone varchar2(13);	
      BEGIN
        IF (LENGTH( :NEW.phone ) < 10) THEN    
          ROLLBACK;
        END IF;
    
        IF (LENGTH( :NEW.phone ) = 10) THEN    
          newPhone := '+90' || :NEW.phone;
        END IF;
       
        IF (LENGTH( :NEW.phone ) = 11) THEN    
          newPhone := '+9' || :NEW.phone;
        END IF;
        
        IF (LENGTH( :NEW.phone ) = 12) THEN    
          newPhone := '+' || :NEW.phone;
        END IF;
       
        IF (LENGTH( :NEW.phone ) = 13) THEN    
          newPhone := :NEW.phone;
        END IF;
        
        IF (LENGTH( :NEW.phone ) > 13) THEN    
          ROLLBACK;
        END IF;
        
        :NEW.phone := newPhone;			
    END;


--drop trigger roomCapacity;

CREATE OR REPLACE TRIGGER roomCapacity
  BEFORE UPDATE ON Room 
    FOR EACH ROW
      BEGIN
        IF ( :NEW.numberOfPatient < 3 ) THEN
          null;				
        ELSE
          ROLLBACK;
        END IF;
      END;

*/


