CREATE TABLE users (
	user_email VARCHAR(40) PRIMARY KEY,
	user_name VARCHAR(50),
	user_password VARCHAR(20),
	user_type VARCHAR(8)
);


CREATE TABLE categories (
	category_id INT PRIMARY KEY,
	category_name VARCHAR(20)
);

CREATE TABLE events (
	event_id INT PRIMARY KEY AUTO_INCREMENT,
	event_name VARCHAR(50),
	total_tickets INT,
	available_tickets INT,
	venue VARCHAR(50),
	startdate DATE,
	starttime TIME,
	user_email VARCHAR(40),
	category_id INT, 
	FOREIGN KEY (user_email) REFERENCES users(user_email),
	FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

CREATE TABLE bookings (
	booking_id INT NOT NULL AUTO_INCREMENT,
	user_id VARCHAR(40),
	event_id INT,
	tickets INT, 
	FOREIGN KEY (user_id) REFERENCES users(user_email),
	FOREIGN KEY (event_id) REFERENCES events(event_id),
	PRIMARY KEY (booking_id)
);
	
CREATE TABLE favorites (
	favorite_id INT NOT NULL AUTO_INCREMENT,
	user_id VARCHAR(40),
	event_id INT,
	FOREIGN KEY (user_id) REFERENCES users(user_email),
	FOREIGN KEY (event_id) REFERENCES events(event_id),
	PRIMARY KEY (favorite_id)
	);

/* CREATE TABLE cat-links (
	event_id INT,
	category_id INT,
	FOREIGN KEY (event_id) REFERENCES events(id),
	FOREIGN KEY (category_id) REFERENCES categories(id),
	PRIMARY KEY (event_id, category_id)
); */
	

INSERT INTO categories VALUES
(1, 'sport'),
(2, 'musik'),
(3, 'teater'),
(4, 'underhållning'),
(5, 'barn')
;

INSERT INTO users (user_email, user_name, user_password, user_type) VALUES
('emmabac@kth.se', 'Emma Bäckström', 'melon', 'admin'),
('mawestl@kth.se', 'Maria Westling', 'melon', 'admin'),
('simonesp@kth.se', 'Simone Stenis Perron', 'melon', 'user'),
('clonn@kth.se', 'Caroline Lönn', 'melon', 'user'),
('kth@kth.se', 'KTH', 'melon', 'creator'), 
('kbm@medieteknik.com', 'Medietekniks Klubbmästeri', 'melon', 'creator'),
('bearwithusmusic@gmail.com', 'Bear With Us', 'melon', 'creator'),
('astridsworld@gmail.com', 'Astrid Lindgrens Värld', 'melon', 'creator'),
('aik@aik.se', 'AIK', 'melon', 'creator')
;


INSERT INTO events (event_id, event_name, total_tickets, available_tickets, venue, startdate, starttime, user_email, category_id) VALUES
(1, 'Bear With Us Live @ META', 149, 149, 'META', '2015-12-31', '22:00:00',  'bearwithusmusic@gmail.com', 2),
(2, 'Pippi på Äventyr', 200, 150, 'Astrid Lindgrens Värld', '2016-04-13', '13:30:00',  'astridsworld@gmail.com', 5),
(3, 'AIK vs Brommapojkarna', 45000, 30000, 'Friends Arena', '2016-03-26', '20:45:00', 'aik@aik.se', 1),
(4, 'AIK vs IFK Norrköping', 45000, 40000, 'Friends Arena', '2016-04-27', '16:00:00', 'aik@aik.se', 1),
(5, 'Torsdagspub!', 149, 149, 'META', '2016-01-21', '17:00:00', 'kbm@medieteknik.com', 4),
(6, 'Bear With Us Unplugged', 300, 200, 'ROQ', '2016-02-14', '23:00:00', 'bearwithusmusic@gmail.com', 2),
(7, 'Tentapub #2', 149, 149, 'META', '2016-01-16', '18:00:00', 'kbm@medieteknik.com', 4)
;


/*
CREATE FUNCTION decTickets() RETURNS trigger AS shipmentTrigger
    BEGIN
             ... BLAH BLAH ... SQL STATEMENTS;
        RETURN NEW;
    END;
$pname$ LANGUAGE plpgsql;

CREATE TRIGGER shipmentTrigger
AFTER UPDATE OF shipment_id on shipments
REFERENCING
	OLD ROW AS OldTuple,
	NEW ROW AS NewTuple
FOR EACH ROW
WHEN (0=(SELECT stock FROM stock))
        EXECUTE PROCEDURE decTickets();

==============================================================

CREATE FUNCTION decTickets() 
RETURNS trigger AS shipmentTrigger
    BEGIN
             ... BLAH BLAH ... SQL STATEMENTS;
        RETURN NEW;
    END;
$pname$ LANGUAGE plpgsql;

CREATE TRIGGER shipmentTrigger
AFTER INSERT ON bookings
REFERENCING
	OLD ROW AS OldTuple,
	NEW ROW AS NewTuple
FOR EACH ROW
WHEN (NewTuple.tickets > (SELECT available_tickets 
						  FROM events
						  WHERE event_id = NewTuple.event_id))
        EXECUTE PROCEDURE decTickets();


==============================================================

CREATE FUNCTION decTickets() RETURNS trigger AS $pname$
    BEGIN
        IF (SELECT available_tickets FROM events WHERE event_id = NEW.event_id) < NEW.tickets THEN
            RAISE EXCEPTION 'There is no stock to ship.';
        END IF;

        IF TG_OP = 'INSERT' THEN
            UPDATE events 
            SET available_tickets = available_tickets - NEW.tickets 
            WHERE event_id = NEW.event_id;
        END IF;
    
        RETURN NEW;
    END;
    
$pname$ LANGUAGE plpgsql;
CREATE TRIGGER check_tickets
    BEFORE INSERT ON bookings 
    FOR EACH ROW
        EXECUTE PROCEDURE decTickets();

*/





