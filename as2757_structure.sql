CREATE TABLE IF NOT EXISTS `AUTHOR` (
  `AUTHORID` int(11) NOT NULL,
  `ANAME` varchar(25) NOT NULL
) ;
CREATE TABLE IF NOT EXISTS `BOOK` (
  `DOCID` int(11) NOT NULL,
  `ISBN` int(11) NOT NULL
) ;
CREATE TABLE IF NOT EXISTS `BORROWS` (
`BORNUMBER` int(11) NOT NULL,
  `READERID` int(11) NOT NULL,
  `DOCID` int(11) NOT NULL,
  `COPYNO` int(11) NOT NULL,
  `LIBID` int(11) NOT NULL,
  `BDTIME` datetime NOT NULL,
  `RDTIME` datetime DEFAULT NULL
) ;
CREATE TABLE IF NOT EXISTS `BRANCH` (
`LIBID` int(11) NOT NULL,
  `LNAME` varchar(25) NOT NULL,
  `LLOCATION` varchar(50) NOT NULL
);
CREATE TABLE IF NOT EXISTS `CHIEF_EDITOR` (
`EDITOR_ID` int(11) NOT NULL,
  `ENAME` varchar(25) NOT NULL
);
CREATE TABLE IF NOT EXISTS `COPY` (
  `DOCID` int(11) NOT NULL,
  `COPYNO` int(11) NOT NULL,
  `LIBID` int(11) NOT NULL,
  `POSITION` varchar(25) NOT NULL
);
CREATE TABLE IF NOT EXISTS `DOCUMENT` (
`DOCID` int(11) NOT NULL,
  `TITLE` varchar(25) NOT NULL,
  `PDATE` date NOT NULL,
  `PUBLISHERID` int(11) NOT NULL
);
CREATE TABLE IF NOT EXISTS `INV_EDITOR` (
  `DOCID` int(11) NOT NULL,
  `ISSUE_NO` int(11) NOT NULL,
  `IENAME` varchar(25) NOT NULL
) ;
CREATE TABLE IF NOT EXISTS `JOURNAL_ISSUE` (
  `DOCID` int(11) NOT NULL,
  `ISSUE_NO` int(11) NOT NULL,
  `SCOPE` varchar(50) NOT NULL
);
CREATE TABLE IF NOT EXISTS `JOURNAL_VOLUME` (
  `DOCID` int(11) NOT NULL,
  `JVOLUME` int(11) NOT NULL,
  `EDITOR_ID` int(11) NOT NULL
);
CREATE TABLE IF NOT EXISTS `PROCEEDINGS` (
  `DOCID` int(11) NOT NULL,
  `CDATE` date NOT NULL,
  `CLOCATION` varchar(50) NOT NULL,
  `CEDITOR` varchar(25) NOT NULL
);
CREATE TABLE IF NOT EXISTS `PUBLISHER` (
`PUBLISHERID` int(11) NOT NULL,
  `PUBNAME` varchar(25) NOT NULL,
  `ADDRESS` varchar(50) NOT NULL
);
CREATE TABLE IF NOT EXISTS `READER` (
`READERID` int(11) NOT NULL,
  `RTYPE` varchar(25) NOT NULL,
  `RNAME` varchar(25) NOT NULL,
  `ADDRESS` varchar(50) NOT NULL
) ;
CREATE TABLE IF NOT EXISTS `RESERVES` (
`RESNUMBER` int(11) NOT NULL,
  `READERID` int(11) NOT NULL,
  `DOCID` int(11) NOT NULL,
  `COPYNO` int(11) NOT NULL,
  `LIBID` int(11) NOT NULL,
  `DTIME` datetime NOT NULL
);
CREATE TABLE IF NOT EXISTS `WRITES` (
  `AUTHORID` int(11) NOT NULL,
  `DOCID` int(11) NOT NULL
);

ALTER TABLE `AUTHOR`
 ADD PRIMARY KEY (`AUTHORID`);
ALTER TABLE `BOOK`
 ADD PRIMARY KEY (`DOCID`);
ALTER TABLE `BORROWS`
  ADD PRIMARY KEY (`BORNUMBER`);
ALTER TABLE `BRANCH`
 ADD PRIMARY KEY (`LIBID`);
ALTER TABLE `CHIEF_EDITOR`
 ADD PRIMARY KEY (`EDITOR_ID`);
ALTER TABLE `COPY`
 ADD PRIMARY KEY (`DOCID`,`COPYNO`,`LIBID`);
ALTER TABLE `DOCUMENT`
 ADD PRIMARY KEY (`DOCID`);
ALTER TABLE `INV_EDITOR`
 ADD PRIMARY KEY (`DOCID`,`ISSUE_NO`,`IENAME`);
ALTER TABLE `JOURNAL_ISSUE`
 ADD PRIMARY KEY (`DOCID`, `ISSUE_NO`);
ALTER TABLE `JOURNAL_VOLUME`
 ADD PRIMARY KEY (`DOCID`);
ALTER TABLE `PROCEEDINGS`
 ADD PRIMARY KEY (`DOCID`);
ALTER TABLE `PUBLISHER`
 ADD PRIMARY KEY (`PUBLISHERID`);
ALTER TABLE `READER`
 ADD PRIMARY KEY (`READERID`);
ALTER TABLE `RESERVES`
 ADD PRIMARY KEY (`RESNUMBER`);
ALTER TABLE `WRITES`
 ADD PRIMARY KEY (`AUTHORID`,`DOCID`);


ALTER TABLE `BORROWS`
MODIFY `BORNUMBER` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `BRANCH`
MODIFY `LIBID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `CHIEF_EDITOR`
MODIFY `EDITOR_ID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `DOCUMENT`
MODIFY `DOCID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `PUBLISHER`
MODIFY `PUBLISHERID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `READER`
MODIFY `READERID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `RESERVES`
MODIFY `RESNUMBER` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `BOOK`
ADD CONSTRAINT `FK_BOOK_DOCID` FOREIGN KEY (`DOCID`) REFERENCES `DOCUMENT` (`DOCID`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `BORROWS`
ADD CONSTRAINT `FK_BORR_COPYINFO` FOREIGN KEY (`DOCID`, `COPYNO`, `LIBID`) REFERENCES `COPY` (`DOCID`, `COPYNO`, `LIBID`) ON DELETE RESTRICT ON UPDATE CASCADE,
ADD CONSTRAINT `FK_BORR_READERID` FOREIGN KEY (`READERID`) REFERENCES `READER` (`READERID`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `COPY`
ADD CONSTRAINT `FK_COPY_DOCID` FOREIGN KEY (`DOCID`) REFERENCES `DOCUMENT` (`DOCID`) ON DELETE RESTRICT ON UPDATE CASCADE,
ADD CONSTRAINT `FK_COPY_LIBID` FOREIGN KEY (`LIBID`) REFERENCES `BRANCH` (`LIBID`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `DOCUMENT`
ADD CONSTRAINT `FK_DOCPUBID` FOREIGN KEY (`PUBLISHERID`) REFERENCES `PUBLISHER` (`PUBLISHERID`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `JOURNAL_VOLUME`
ADD CONSTRAINT `FK_DOCID_JRNVOL` FOREIGN KEY (`DOCID`) REFERENCES `DOCUMENT` (`DOCID`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `PROCEEDINGS`
ADD CONSTRAINT `FK_PROC_DOCID` FOREIGN KEY (`DOCID`) REFERENCES `DOCUMENT` (`DOCID`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `RESERVES`
ADD CONSTRAINT `FK_RES_COPYINFO` FOREIGN KEY (`DOCID`, `COPYNO`, `LIBID`) REFERENCES `COPY` (`DOCID`, `COPYNO`, `LIBID`) ON DELETE RESTRICT ON UPDATE CASCADE,
ADD CONSTRAINT `FK_RES_READERID` FOREIGN KEY (`READERID`) REFERENCES `READER` (`READERID`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `WRITES`
ADD CONSTRAINT `FK_WRITES_AUTHORID` FOREIGN KEY (`AUTHORID`) REFERENCES `AUTHOR` (`AUTHORID`) ON DELETE RESTRICT ON UPDATE CASCADE,
ADD CONSTRAINT `FK_WRITES_DOCID` FOREIGN KEY (`DOCID`) REFERENCES `DOCUMENT` (`DOCID`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `JOURNAL_VOLUME`
ADD CONSTRAINT `FK_EDITORID_JRNVOL` FOREIGN KEY (`EDITOR_ID`) REFERENCES `CHIEF_EDITOR` (`EDITOR_ID`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `JOURNAL_ISSUE`
ADD CONSTRAINT `FK_DOCID_JRNLVOL` FOREIGN KEY (`DOCID`) REFERENCES `JOURNAL_VOLUME` (`DOCID`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `INV_EDITOR`
ADD CONSTRAINT `FK_DOCIDandISSUENO_JOURNALISSUE` FOREIGN KEY (`DOCID`, `ISSUE_NO`) REFERENCES `JOURNAL_ISSUE` (`DOCID`, `ISSUE_NO`) ON DELETE RESTRICT ON UPDATE CASCADE;