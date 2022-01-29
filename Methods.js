//gefunden auf: https://www.javascripttutorial.net/javascript-dom/javascript-checkbox/


//const upload = document.getElementById("upload");
//https://www.youtube.com/watch?v=dD2rea_fCFk

let input = document.querySelector('input');
var text;
var i;
var counter = 0;
var y;
var datum;
var datumend;
var zeit;


input.addEventListener('change', start => {
    let files = input.files;

    if(files.length == 0) return;

    const file = files[0];

    let reader = new FileReader();

    reader.onload = (e) =>  {
        const file = e.target.result;
        const lines = file.split(/\r\n|\n/);
        //text = lines.join('\n');


        for(i = 0; i < lines.length;i ++){
            if(lines[i] == 'BEGIN:VEVENT'){
                counter ++;
            }
        }
        console.log(counter);
        //https://www.youtube.com/watch?v=tMeDkp1J2OM

        const myarray = [];

        counter = 0

        //iteriert über alle Zeilen der Textdatei
        for(i = 0; i < lines.length; i++){

            //Nach Konvention in der ICS-Datei der Start eines Termines
            if(lines[i] == 'BEGIN:VEVENT'){
                myarray[counter] = [];

                //grenzt Zeilen innerhalb eines Termines ein
                while(lines[i] != 'END:VEVENT'){

                    //DTSTART;TZID=Europe/Berlin:20220201T130000 (Format in ICS-Datei)
                    //Trennt Strings vor und nach dem Doppelpunkt
                    y = lines[i].split(":");
                    if (y[0] === 'DTSTART;TZID=Europe/Berlin') {

                        //Trennt zweiten String in Datum und Zeit auf : <20220201>T<130000>
                        datum = y[1].split("T")
                        zeit = datum [1];

                        //Erstellt das richtige Zeitformat
                        zeit = zeit.slice(0, 2) + ":" + zeit.slice(2,4) + ":" +  zeit.slice(4,6);

                        datum = datum[0];
                        datum = datum.slice(0, 4) + "-" + datum.slice(4,6) + "-" +  datum.slice(6,8);

                        myarray[counter][0] = datum;
                        myarray[counter][1] = zeit;

                        //Erkennt endzeitpunkt des Termines
                    } else if (y[0] === 'DTEND;TZID=Europe/Berlin') {
                        datumend = y[1].split("T");
                        zeit = datumend [1];
                        zeit = zeit.slice(0, 2) + ":" + zeit.slice(2,4) + ":" +  zeit.slice(4,6);

                        myarray [counter][2] = zeit;

                        //CATEGORIES:Klausur
                    } else if (y[0] === 'CATEGORIES') {

                        myarray[counter][3] = y[1];
                    }

                    //DESCRIPTION:Gehalten von Schönemann\, M.
                    else if (y[0] === 'DESCRIPTION') {

                        myarray[counter][4] = y[1];

                    }

                    //LOCATION:Stadthalle Saal 1 & 2 (FB)
                    else if (y[0] === 'LOCATION') {

                        myarray[counter][5] = y[1];

                    }

                    //SUMMARY:Einführung in die Wirtschaftswissenschaften - Klausur
                    else if (y[0] === 'SUMMARY') {

                        myarray[counter][6] = y[1];

                    }

                    //COMMENT:Klausur ohne Veranstaltung
                    else if (y[0] === 'COMMENT') {

                        myarray[counter][7] = y[1];
                    }
                    i++;
                }
                counter ++;
            }
        }

        //Iteriert über das erstellte Array und gibt es in der Konsole aus
        for(i = 0; i < counter;i++){
            console.log("Neuer Eintrag!")
            for(y = 0; y < 8; y++){
                console.log(myarray[i][y]);
            }


        }
    }


    reader.onerror = (e) => alert(e.tag.error.name);

    reader.readAsText(file);

});

