#include "LedControl.h"

/*
  LED Module
  pin 12 is connected to the DataIn
  pin 11 is connected to LOAD(CS)
  pin 10 is connected to the CLK
  Orientation: VCC on bottom left
*/
LedControl lc = LedControl(12, 10, 11, 1);
unsigned long shortDelay = 200;
unsigned long longDelay = 500;

//Sound Sensor Potetiometer
//int sensorPin = A0;
//int sensorValue = 0;

//Sound Sensor Threshold
int micPin = 13;
int threshold;

//Motion Sensor
int pirPin = 7;
int pirValue;

void setup()
{
  // wakeup call
  lc.shutdown(0, false);
  lc.setIntensity(0, 0); //2nd var = 0-15 where 0 is not off
  lc.clearDisplay(0);

  //Sound Sensor
  //Serial.begin(9600);
  pinMode(micPin, INPUT);

  //motion sensor
  pinMode(pirPin, INPUT);

  startupAnimation();
}

void startupAnimation()
{
  //first is column 1, bottom to top (tilt head to right)
  const byte FRAMES[][8] = {
      {B01110000,
       B01010101,
       B01110000,
       B10000101,
       B00000000,
       B10010100,
       B00001010,
       B00000100},
       };

  //Show each frame
  const int FRAME_COUNT = sizeof(FRAMES) / 8;
  for (int i = 0; i < FRAME_COUNT; i++)
  {
    for (int j = 0; j < 8; j++)
    {
      lc.setRow(0, j, FRAMES[i][j]);
    }
    delay(longDelay);
    delay(longDelay);
    delay(longDelay);
  }

  //Blank Frame
  lc.clearDisplay(0);
}

void phoneAnimation()
{
  //first is column 1, bottom to top (tilt head to right)
  const byte FRAMES[][8] = {
      {B11001110,
       B10101110,
       B10010110,
       B10010110,
       B10010110,
       B10010110,
       B10101110,
       B11001110},
      {B11000111,
       B10100111,
       B10010011,
       B10010011,
       B10010111,
       B10010110,
       B10101110,
       B11001110},
      {B11001110,
       B10101110,
       B10010110,
       B10010111,
       B10010011,
       B10010011,
       B10100111,
       B11000111},
      {B11000111,
       B10100111,
       B10010011,
       B10010011,
       B10010111,
       B10010110,
       B10101110,
       B11001110},
      {B11001110,
       B10101110,
       B10010110,
       B10010111,
       B10010011,
       B10010011,
       B10100111,
       B11000111},
      {B11001110,
       B10101110,
       B10010110,
       B10010110,
       B10010110,
       B10010110,
       B10101110,
       B11001110}};

  //Show each frame
  const int FRAME_COUNT = sizeof(FRAMES) / 8;
  for (int i = 0; i < FRAME_COUNT; i++)
  {
    for (int j = 0; j < 8; j++)
    {
      lc.setRow(0, j, FRAMES[i][j]);
    }
    delay(shortDelay);
  }

  //Blank Frame
  lc.clearDisplay(0);
  delay(longDelay);
}

void humanAnimation()
{
  //first is column 1, bottom to top (tilt head to right)
  const byte FRAMES[][8] = {

      {B00000000,
       B00100110,
       B00100110,
       B00100000,
       B00100000,
       B00100110,
       B00100110,
       B00000000},
      {B00000000,
       B00100110,
       B00100110,
       B00100000,
       B00100000,
       B00100110,
       B00100110,
       B00000000},
      {B00000000,
       B00100100,
       B00100100,
       B00100000,
       B01100000,
       B01100100,
       B00100100,
       B00000000}};

  //Show each frame
  const int FRAME_COUNT = sizeof(FRAMES) / 8;
  for (int i = 0; i < FRAME_COUNT; i++)
  {
    for (int j = 0; j < 8; j++)
    {
      lc.setRow(0, j, FRAMES[i][j]);
    }
    delay(longDelay);
  }

  //Blank Frame
  lc.clearDisplay(0);
  delay(longDelay);
}

// void single()
// {
//   //col 0-7 left to right
//   //row 0-7 bottom to top
//   int col = 1 - 1;
//   int row = 1 - 1;

//   //on
//   lc.setLed(0, col, row, true);
//   delay(shortDelay);

//   //off
//   lc.setLed(0, col, row, false);
//   delay(longDelay);

//   lc.clearDisplay(0);
// }

void ringThree()
{
  phoneAnimation();
  phoneAnimation();
  phoneAnimation();
}

void checkMic()
{
  //sensorValue = analogRead(sensorPin);
  //Serial.println(sensorValue, DEC);

  threshold = digitalRead(micPin);
  if (threshold == HIGH)
  {
    ringThree();
  }
}

void checkMotion()
{
  pirValue = digitalRead(pirPin);
  if (pirValue == HIGH)
  {
    humanAnimation();
    //lc.setLed(0, 0, 0, true);
  } else {
    //lc.setLed(0, 0, 0, false);
  }
}

void loop()
{
  checkMic();
  checkMotion();
  //single();
}