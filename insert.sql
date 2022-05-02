--Departments req
INSERT INTO Departments VALUES('Electronics', 'Jim Bob', 'Parts');
INSERT INTO Departments VALUES('Motors', 'Bim Job', 'Parts');
INSERT INTO Departments VALUES('Transmissions', 'Bjim Bjob', 'Parts');
INSERT INTO Departments VALUES('Cleaning Supplies', 'Greg Gory', 'General');
INSERT INTO Departments VALUES('Oil Filters', 'Bob Oilguy', 'Oils');
INSERT INTO Departments VALUES('Engine Oil', 'Jim Oilguy', 'Oils');

--Supplier
INSERT INTO Supplier VALUES('Mobil2', 'Toto Wolffman', '1234567890');
INSERT INTO Supplier VALUES('Borsche', 'Christopher Horner', '9987654321');
INSERT INTO Supplier VALUES('Holkswagen', 'Gunther Steiner', '420256644');

--Items req
INSERT INTO Item VALUES('2597474993', 'Motors', 2, 300.00, 100.00, 200.00, 2, 'Holkswagen'); --NA6 Engine
INSERT INTO Item VALUES('9348584637', 'Motors', 3, 1600.00, 1000.00, 1200.00, 1, 'Holkswagen'); --NB2 Engine
INSERT INTO Item VALUES('6676943523', 'Electronics', 10, 119.99, 89.98, 94.99, 20, 'Mobil2'); --CBR250R Gauge cluster
INSERT INTO Item VALUES('7842726384', 'Engine Oil', 20, 39.99, 20.00, 24.99, 20, 'Mobil2'); --5W-30 Mobil2 engine oil
INSERT INTO Item VALUES('3588727827', 'Cleaning Supplies', 50, 3.99, 1.99, 2.49, 100, 'Borsche'); --Trees new car smell

--Expiration Dates req
INSERT INTO ItemExpirations VALUES('2597474993', '2022-04-20');
INSERT INTO ItemExpirations VALUES('2597474993','2022-06-07');

--Item location
INSERT INTO ItemLocation VALUES('2597474993', 10, 'R', 1, 0, 2);
INSERT INTO ItemLocation VALUES('9348584637', 10, 'R', 1, 0, 4);
INSERT INTO ItemLocation VALUES('6676943523', 10, 'L', 1, 2, 5);
INSERT INTO ItemLocation VALUES('7842726384', 10, 'R', 4, 3, 2);
INSERT INTO ItemLocation VALUES('3588727827', 1, 'L', 3, 4, 1);

--Employess req
INSERT INTO Employees(empName, empPermission, empDept) VALUES('Gilbert Guillermo', 0, 'Electronics');
INSERT INTO Employees(empName, empPermission, empDept) VALUES('Eddie Poulson', 1, 'Motors');
INSERT INTO Employees(empName, empPermission, empDept) VALUES('Bogdan Tanaskovic', 0, 'Cleaning Supplies');

--Delivery
INSERT INTO Delivery VALUES(1, '2022-04-17', 1, 13);

--Orders req
INSERT INTO Orders VALUES('2597474993', 1, '2022-04-10', FALSE, NULL);
INSERT INTO Orders VALUES('9348584637', 2, '2022-04-01', TRUE, 1);

--Customers req
INSERT INTO Customers VALUES('7spsfa7ngx', 'Derek Dorr', '2597474993');
INSERT INTO Customers VALUES('43ha9wdvnb', 'Faraj Yousef', '9348584637');
INSERT INTO Customers VALUES('k6rr9auad3', 'Alejandro Alcantar', '6676943523');
INSERT INTO Customers VALUES('7matq4wn52', 'Tim Gentry', '7842726384');
INSERT INTO Customers VALUES('bcegc3p84q', 'Kyle Rincon', '3588727827');

--Transactions
INSERT INTO Transactions VALUES(NULL, '2022-04-10 12:03:54', '2597474993', 1, 300.00, '7spsfa7ngx');
INSERT INTO Transactions VALUES(NULL, '2022-04-01 14:46:02', '9348584637', 2, 3200.00, 'bcegc3p84q');

--Coupons
INSERT INTO Coupons VALUES(332, '6676943523', 20.00, 1, '43ha9wdvnb');
INSERT INTO Coupons VALUES(334, '6676943523', 20.00, 1, '7matq4wn52');