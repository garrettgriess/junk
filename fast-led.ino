#include <FastLED.h>
#define NUM_LEDS 300
#define DATA_PIN 3
#define MAX_ALL_BRIGHT 30 //The maximum brightness when all lights are lit to prevent flickering

CRGB leds[NUM_LEDS];

void setup() {
  //Serial.begin(9600);
  
  FastLED.addLeds<WS2812B, DATA_PIN, GRB>(leds, NUM_LEDS);  // GRB ordering is typical
}

void loop() { 
  //Serial.println("Loop Started");
  FastLED.clear();

  cylon();
  
  /*
  // Demo All...
  pixelRun();
  backAndForth();
  for (int i = 0; i < 50; i++) {
    randomBlink();
  }
  for (int i = 0; i < 3; i++) {
    pulseAll();
  }
  for (int i = 0; i < 2; i++) {
    rainbowFade();
  }
  for (int i = 0; i < 5; i++) {
    allBlink();
  }
  for (int i = 0; i < 25; i++) {
    marchThree();
  }
  for (int i = 0; i < 3; i++) {
    pixelBlur();
  }
  cylon();
  */
  
  /*
  //...Except These
  slowBurn()
  solidColor();
  for (int i = 0; i < 50; i++) {
    externalControl();
  }
  */

}

void cylon() {
  FastLED.clear();
  for(int i = 1; i < NUM_LEDS-1; i++) {
    leds[i+0].setHSV(0, 255, 50);
    leds[i+1].setHSV(0, 255, 255);
    leds[i+2].setHSV(0, 255, 50);
    FastLED.show();
    leds[i+0] = CRGB::Black;
    leds[i+1] = CRGB::Black;
    leds[i+2] = CRGB::Black;
    FastLED.show();
  }
  for(int i = NUM_LEDS; i > 0; i--) {
    leds[i+0].setHSV(0, 255, 50);
    leds[i+1].setHSV(0, 255, 255);
    leds[i+2].setHSV(0, 255, 50);
    FastLED.show();
    leds[i+0] = CRGB::Black;
    leds[i+1] = CRGB::Black;
    leds[i+2] = CRGB::Black;
    FastLED.show();
  }
}


//Idea: Add one to the end, one at a time from the right.

void slowBurn() {
  FastLED.clear();
  for(int i = 0; i < NUM_LEDS; i++) {
    for (int j = MAX_ALL_BRIGHT; j > 0; j--) {
      leds[i].setHSV(25, 255, j);
      FastLED.show();
    }
  }
}

void pixelBlur() {
  FastLED.clear();
  for (int i = 0; i < NUM_LEDS; i++) {
    for (int j = 0; j <= 25; j++) {
      leds[i+j].setHSV(150, 255, j * 10);
    }
    FastLED.show();
  }
}

void marchThree() {
  FastLED.clear();
  for (int i = 0; i < NUM_LEDS; i = i+4) {
    leds[i-0].setRGB( 0, 0, MAX_ALL_BRIGHT);
    leds[i-1].setRGB( 0, MAX_ALL_BRIGHT, MAX_ALL_BRIGHT);
    leds[i-2].setRGB( 0, MAX_ALL_BRIGHT, 0);
    leds[i-3].setRGB( 0, 0, 0);
  }
  FastLED.show();
  delay(50);
  for (int i = 0; i < NUM_LEDS; i = i+4) {
    leds[i-1].setRGB( 0, 0, MAX_ALL_BRIGHT);
    leds[i-2].setRGB( 0, MAX_ALL_BRIGHT, MAX_ALL_BRIGHT);
    leds[i-3].setRGB( 0, MAX_ALL_BRIGHT, 0);
    leds[i-0].setRGB( 0, 0, 0);
  }
  FastLED.show();
  delay(50);
  for (int i = 0; i < NUM_LEDS; i = i+4) {
    leds[i-2].setRGB( 0, 0, MAX_ALL_BRIGHT);
    leds[i-3].setRGB( 0, MAX_ALL_BRIGHT, MAX_ALL_BRIGHT);
    leds[i-0].setRGB( 0, MAX_ALL_BRIGHT, 0);
    leds[i-1].setRGB( 0, 0, 0);
  }
  FastLED.show();
  delay(50);
  for (int i = 0; i < NUM_LEDS; i = i+4) {
    leds[i-3].setRGB( 0, 0, MAX_ALL_BRIGHT);
    leds[i-0].setRGB( 0, MAX_ALL_BRIGHT, MAX_ALL_BRIGHT);
    leds[i-1].setRGB( 0, MAX_ALL_BRIGHT, 0);
    leds[i-2].setRGB( 0, 0, 0);
  }
  FastLED.show();
  delay(50);
}

void allBlink() {
  FastLED.clear();
  for (int i = 0; i < NUM_LEDS; i++) {
      int red = 0;
      int green = 0;
      int blue = MAX_ALL_BRIGHT - 5;
      leds[i].setRGB( red, green, blue);
  }
  FastLED.show();
  delay(500);
  for (int i = 0; i < NUM_LEDS; i++) {
    int red = 0;
    int green = MAX_ALL_BRIGHT - 5;
    int blue = 0;
    leds[i].setRGB( red, green, blue);
  }
  FastLED.show();
  delay(500);
}

void solidColor() {
  FastLED.clear();
  for (int i = 0; i < NUM_LEDS; i++) {
      int red = 0;
      int green = 0;
      int blue = MAX_ALL_BRIGHT - 5;
      leds[i].setRGB( red, green, blue);
  }
  FastLED.show();
  delay(5000);
}

void externalControl() {
  FastLED.clear();
  int val = analogRead(7  );
  int input = map(val, 0, 1023, 0, NUM_LEDS);
  for (int i = 0; i < input; i++) {
    leds[i] = CRGB::Blue;
  }
  FastLED.show();
}

void rainbowFade() {
  FastLED.clear();
  for (int i = 0; i <= 255; i++) {
    for (int j = 0; j < NUM_LEDS; j++) {
      int hue = i;
      int saturation = 255;
      int brightness = MAX_ALL_BRIGHT;
      leds[j].setHSV( hue, saturation, brightness);
    }
    FastLED.show();
  }
}

void pulseAll() {
  FastLED.clear();
  for (int i = 0; i <= MAX_ALL_BRIGHT; i++) {
    for (int j = 0; j < NUM_LEDS; j++) {
      int red = 0;
      int green = 0;
      int blue = i;
      leds[j].setRGB( red, green, blue);
    }
    FastLED.show();
    delay(25);
  }
  for (int i = MAX_ALL_BRIGHT; i >= 0; i--) {
    for (int j = 0; j < NUM_LEDS; j++) {
      int red = 0;
      int green = 0;
      int blue = i;
      leds[j].setRGB( red, green, blue);  
    }
    FastLED.show();
    delay(25);
  }
}

void randomBlink() {
  FastLED.clear();
 for(int i = 0; i < NUM_LEDS; i++) {
  int fiftyfifty = random(2);

  if (fiftyfifty > 0) {
    leds[i] = CRGB::Black;
  } else {
    int red = 0;
    int green = random(0, 50);
    int blue = random(0, 255);
    leds[i].setRGB( red, green, blue);  
  }
  
 }
 FastLED.show();
 delay(50);
}

void backAndForth() {
  FastLED.clear();
  for(int i = 0; i < NUM_LEDS; i++) {
    leds[i] = CRGB::Blue;
    FastLED.setBrightness(MAX_ALL_BRIGHT);
    FastLED.show();
  }
  for(int i = NUM_LEDS; i >= 0; i--) {
    leds[i] = CRGB::Black;
    FastLED.show();
  }
  for(int i = NUM_LEDS; i >= 0; i--) {
    leds[i] = CRGB::Green;
    FastLED.setBrightness(MAX_ALL_BRIGHT);
    FastLED.show();
  }
  for(int i = 0; i < NUM_LEDS; i++) {
    leds[i] = CRGB::Black;
    FastLED.show();
  }
}

void pixelRun() {
  FastLED.clear();
  for(int i = 0; i < NUM_LEDS; i++) {
    leds[i] = CRGB::Blue;
    FastLED.show();
    leds[i] = CRGB::Black;
    FastLED.show();
  }
}
