CREATE TABLE Departments (
  deptName VARCHAR(20) NOT NULL,
  deptSupervisor VARCHAR(10) NOT NULL,
  deptSection VARCHAR(15) NOT NULL,
  PRIMARY KEY (deptName)
);

CREATE TABLE Supplier (
  supplierID VARCHAR(20) NOT NULL UNIQUE,
  supplierRep VARCHAR(30) NOT NULL,
  supplerRepNum VARCHAR(10) NOT NULL,
  PRIMARY KEY (supplierID)
);

CREATE TABLE Item (
  UPC VARCHAR(10) NOT NULL UNIQUE,
  itemDept VARCHAR(20) NOT NULL,
  itemRestockAmt INT NOT NULL,
  itemPrice FLOAT NOT NULL,
  itemSalePrice FLOAT,
  itemWholeSalePrice FLOAT,
  itemCurrStock INT NOT NULL,
  supplierID VARCHAR(20),
  PRIMARY KEY (UPC),
  FOREIGN KEY (supplierID) REFERENCES Supplier (supplierID),
  FOREIGN KEY (itemDept) REFERENCES Departments (deptName)
 );
 
 CREATE TABLE ItemExpirations (
   itemUPC VARCHAR(10) NOT NULL,
   itemExpDate DATE NOT NULL,
   PRIMARY KEY (itemExpDate),
   FOREIGN KEY (itemUPC) REFERENCES Item(UPC)
);

CREATE TABLE ItemLocation (
  itemUPC VARCHAR(10) NOT NULL,
  locationAisle INT NOT NULL,
  locationSide VARCHAR(2) NOT NULL,
  locationSecNum INT NOT NULL,
  locationShelfNum INT NOT NULL,
  locationItemFromStart INT NOT NULL,
  PRIMARY KEY (locationAisle, locationSide, locationSecNum, locationShelfNum, locationItemFromStart),
  FOREIGN KEY (itemUPC) REFERENCES Item (UPC)
);
  
CREATE TABLE Employees (
  empID INT NOT NULL AUTO_INCREMENT,
  empName VARCHAR(40) NOT NULL,
  empPermission INT CHECK (empPermission < 2) NOT NULL,
  empDept VARCHAR(20) NOT NULL,
  PRIMARY KEY (empID, empPermission),
  FOREIGN KEY (empDept) REFERENCES Departments (deptName)
 );
 
 CREATE TABLE Delivery (
   deliveryID INT NOT NULL UNIQUE,
   deliveryDate DATE NOT NULL,
   deliveryPalletAmt INT,
   deliveryTruckNum INT NOT NULL,
   PRIMARY KEY (deliveryID)
);
 
 CREATE TABLE Orders (
   itemUPC VARCHAR(10) NOT NULL,
   orderAmt INT NOT NULL,
   orderPlaced DATE NOT NULL,
   orderOnDelivery BOOL NOT NULL,
   orderDeliveryID INT,
   FOREIGN KEY (itemUPC) REFERENCES Item (UPC),
   FOREIGN KEY (orderDeliveryID) REFERENCES Delivery (deliveryID)
);

  
CREATE TABLE Customers (
  customerID VARCHAR(10) NOT NULL UNIQUE,
  customerName VARCHAR(40),
  customerItemBought VARCHAR(10) NOT NULL,
  PRIMARY KEY (customerID),
  FOREIGN KEY (customerItemBought) REFERENCES Item (UPC)
);
  
CREATE TABLE Transactions (
  transactionID INT AUTO_INCREMENT NOT NULL,
  transactionOccur DATETIME NOT NULL,
  itemUPC VARCHAR(10) NOT NULL,
  transactionItemAmt INT NOT NULL,
  transactionItemPrice FLOAT NOT NULL,
  customerID VARCHAR(10) NOT NULL UNIQUE,
  PRIMARY KEY (transactionID, customerID),
  FOREIGN KEY (itemUPC) REFERENCES Item (UPC),
  FOREIGN KEY (customerID) REFERENCES Customers (customerID)
);

CREATE TABLE Coupons (
  couponID INT NOT NULL UNIQUE,
  couponItem VARCHAR(10) NOT NULL,
  couponDiscount FLOAT NOT NULL,
  couponLeveling INT NOT NULL,
  customerID VARCHAR(10) NOT NULL,
  PRIMARY KEY (couponID),
  FOREIGN KEY (customerID) REFERENCES Customers (customerID)
);
  