CREATE TABLE empresa(
    idempresa bigint AUTO_INCREMENT,
    enombre varchar(150),
    edireccion varchar(150),
    PRIMARY KEY (idempresa)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE persona (
    nombre varchar(150),
    apellido varchar(150),
    documento int(15),
    PRIMARY KEY (documento)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE responsable (
    rnumeroempleado bigint,
    rnumerolicencia bigint,
	rnombre varchar(150), 
    rapellido  varchar(150),
    rdocumento int(15), 
    PRIMARY KEY (rdocumento),
    FOREIGN KEY (rdocumento) REFERENCES persona (documento)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
CREATE TABLE viaje (
    idviaje bigint AUTO_INCREMENT, /*codigo de viaje*/
	vdestino varchar(150),
    vcantmaxpasajeros int,
	idempresa bigint,
    rnumeroempleado bigint,
    rdocumento int(15),
    vimporte float,
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
	FOREIGN KEY (rdocumento) REFERENCES responsable (rdocumento)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;
	
CREATE TABLE pasajero (
    pdocumento varchar(15),
    pnombre varchar(150), 
    papellido varchar(150), 
	ptelefono int(20), 
	idviaje bigint,
    PRIMARY KEY (pdocumento),
    FOREIGN KEY (pdocumento) REFERENCES persona (documento)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
	FOREIGN KEY (idviaje) REFERENCES viaje (idviaje)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;