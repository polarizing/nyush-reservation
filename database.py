import copy
import sqlite3
from pprint import pprint
from dateutil.parser import parse
from datetime import datetime
import calendar
from time import gmtime

# turn a python array into format: "'a','b','c','d'"
def sqlarrayFromStrings(arr):
    return "'" + "','".join(arr) + "'"

def sqlarrayFromInts(arr):
    return ",".join([str(x) for x in arr])

def epochFromISO(isotimestr):
    return calendar.timegm(parse(isotimestr).timetuple())

def ISOFromEpoch(epoch):
    return datetime(*gmtime(epoch)[:6])

class TimeConflictException (BaseException):
    pass

class ReservationDatabase:
    def __init__(self, test=False):
        if test:
            self.conn = sqlite3.connect('reservationstest.db')
            try:
                self.conn.execute("""DROP TABLE reservations""")
            except sqlite3.OperationalError as e:
                print("Couldn't drop non-existing table reservations.")
            self.conn.execute("""CREATE TABLE reservations
                (reservid integer primary key, roomnumber text, startdate integer, 
                    enddate integer, name text, email text);
                """)
            things = [
                ["304A", "2016-03-11T03:45:40+08:00", "2016-03-11T04:45:00+08:00", "Skye Im", "ki539@nyu.edu"],
                ["304A", "2016-03-11T04:45:40+08:00", "2016-03-11T05:45:00+08:00", "Skye Im", "ki539@nyu.edu"],
                ["304A", "2016-03-11T06:45:40+08:00", "2016-03-11T07:45:00+08:00", "Skye Im", "ki539@nyu.edu"],
                ["304A", "2016-03-11T07:45:40+08:00", "2016-03-11T08:45:00+08:00", "Skye Im", "ki539@nyu.edu"],
                ["304B", "2016-03-11T00:45:40+08:00", "2016-03-11T23:45:00+08:00", "Skye Im", "ki539@nyu.edu"]
            ]
            for i in range(len(things)):
                things[i][1] = epochFromISO(things[i][1])
                things[i][2] = epochFromISO(things[i][2])
            self.conn.executemany("""INSERT INTO reservations(roomnumber, 
                startdate,  enddate, name, email) 
                VALUES (?, ?, ?, ?, ?)""", things)
            self.conn.commit();
            return
        else:
            self.conn = sqlite3.connect('reservations.db')
        def tableexists(name):
            cursor = self.conn.cursor()
            cursor.execute(
                "SELECT name FROM sqlite_master WHERE type='table' AND name=?",
                [name]
            )
            return len(cursor.fetchall())
        # check for db. create if does not exist.
        resvtableExists = tableexists("reservations")
        if not resvtableExists:
            self.conn.execute("""CREATE TABLE reservations
                (reservid integer primary key, roomnumber text, startdate integer, 
                    enddate integer, name text, email text);
                """)

    def flush(self):
        self.conn.commit()

    def checkIfAvailable(self, roomnumber, startdate, enddate):
        """Check if a given room is available at a given time.

            string roomnumber
            date string startdate, enddate
            returns true if available, false if not.
        """
        startdate = epochFromISO(startdate)
        enddate   = epochFromISO(enddate)
        cursor = self.conn.cursor()
        # for [a, b] and [c, d], to check if they overlap do c < b and a < d
        cursor.execute("""SELECT * FROM reservations WHERE (roomnumber == ?)
             AND (? < enddate) AND (startdate < ?)""", 
             [roomnumber, startdate, enddate])
        results = cursor.fetchall()
        # for result in results:
        #     start = ISOFromEpoch(result[2])
        #     end   = ISOFromEpoch(result[3])
        #     print("Room {r[1]}, {s} ~ {e} by {r[4]}".format(r=result, s=start, e=end))
        if len(results) == 0:
            return True
        return False


    def reserve(self, roomnumber, startdate, enddate, name, email):
        """
            Reserve for a given roomnumber, time, name and email if it is possible.
            Raises an exception if not possible.
            string roomnumber
            date string startdate, enddate
            string name, email
            returns true if available, false if not.
        """
        if not self.checkIfAvailable(roomnumber, startdate, enddate):
            raise TimeConflictException("The given times are already reserved.")
        # Now, move on to reservation.
        startdate = epochFromISO(startdate)
        enddate   = epochFromISO(enddate)
        cursor = self.conn.cursor()
        self.conn.execute("""INSERT INTO reservations(roomnumber, 
                startdate,  enddate, name, email) 
                VALUES (?, ?, ?, ?, ?)""", (roomnumber, startdate, enddate, name, email))
        self.flush()




if __name__=='__main__':
    db = ReservationDatabase(test=True)
    print(db.checkIfAvailable("304A", "2016-03-11T05:45:00", "2016-03-11T06:45:00"))
    print(db.checkIfAvailable("304A", "2016-03-11T05:45:00", "2016-03-11T06:46:00"))
    db.reserve("304A", "2016-03-11T05:45:00", "2016-03-11T06:45:00", "Kevin Li", "kl34@nyu.edu")
    print(db.checkIfAvailable("304A", "2016-03-11T05:45:00", "2016-03-11T06:45:00"))

