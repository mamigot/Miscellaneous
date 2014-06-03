/**
 * Uses the Google Maps API to get the distances from a predetermined starting point
 * to locations denoted by the names on the first column.
 *
 * Each API call takes 1 second to avoid saturation (API doesn't respond otherwise).
 * Runs the onOpen() function first.
 *
 * Spreadsheet currently looks like e.g.:
 * |---NAME-----------------|---DISTANCE (mi)---|
 * |------------------------|-------------------|
 * | Purchase College       | 5.1               |
 * | Manhattanville College | 7.5               |
 * | Iona College           | 12.8              |
 * |------------------------|-------------------|
 *
 * See: https://developers.google.com/apps-script/reference/spreadsheet/
 */
var startingPoint = "Greenwich,CT";
var url = "http://maps.googleapis.com/maps/api/directions/json?origin=" + startingPoint + "&destination=";

var ss = SpreadsheetApp.getActiveSpreadsheet();
var ui = SpreadsheetApp.getUi();

//Only working with the first sheet
var sheet = ss.getSheets()[0];

var namesStartRow = 1;
var namesStartColumn = 1;
var distanceStartRow = namesStartRow;
var distanceStartColumn = namesStartColumn + 1;
var numRows = sheet.getLastRow();
var numColumns = 1;
//https://developers.google.com/apps-script/reference/spreadsheet/sheet#getSheetValues(Integer,Integer,Integer,Integer)
var namesList = sheet.getSheetValues(namesStartRow, namesStartColumn, numRows, numColumns);

/**
 * Parses the distance from the JSON API call and returns it as a float.
 *
 * example: http://maps.googleapis.com/maps/api/directions/json?origin=greenwich,ct&destination=fordham_university
 */
function getDistanceMiles(response){
  if(typeof response === "undefined" || response.status == "NOT_FOUND"){
    Logger.log("typeof response === \"undefined\" || response.status == \"NOT_FOUND\"");
    return 0;
    
  }else{
    try{
      var distance = response.routes[0].legs[0].distance.text;
      return parseFloat(distance, 10);
    }catch(e){
      //Another error of some kind
      Logger.log(e);
      return 0;
    }
    
  }
}

/**
 * Function that executes first. Refer to the comments at the very top of the program.
 */
function onOpen(){
  for(var i = 0; i < namesList.length; i++){
    /* If an API call fails once, try it maxReps number of times because it might
     * return a proper value the following times despite Utilities.slep(1000)...
     * Of course, if the format of the provided location is wrong, after maxReps
     * times the program will be interrupted and the proper error message will show.
     */
    var repCounter = 0;
    var maxReps = 3;
    
    do{
      //Each API call takes 1 second to avoid saturation (API doesn't respond otherwise).
      Utilities.sleep(1000);
      var curr = namesList[i];
      var fullURL = url + curr;
    
      var response = UrlFetchApp.fetch(fullURL);
      var JSONresponse = JSON.parse(response);
    
      var distance = getDistanceMiles(JSONresponse);
      if(distance == 0){
        repCounter++;
        
        if(repCounter < maxReps){
          var errMessage = "Bad response for " + curr;
          ui.alert(errMessage);
          Logger.log(errMessage);
          return;
        }
 
      }else{
        //Write the distance to the cell
        var properField = sheet.getRange(i + 1, distanceStartColumn, 1, 1);
        properField.setValue(distance);
        Logger.log(curr + ": " + distance);
        break;
      }
    }while(repCounter < maxReps)
    
    
  }
  
  sheet.sort(distanceStartColumn);
    
}