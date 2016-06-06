# The Druchii.net Tools

These are the theory crafting tools designed by, and for the Druchii.net community. The tools offer:

1. Combat Calculators, for
 * 9th Age
 * Warhammer Fantasy Battles, 8th edition
 * Warhammer, Age of Sigmar
 * A combination of any supported platform.

2. A Dice Roller
3. A comp comparator.. But this one is going to be added in a different branch (logic!?)

## The project

The goal of the project was to provide a set of easy-to-use tools to support the war-gaming community Druchii.net. Which tool would be developed would depend on the spur of the moment, and the demand. For example, the combat calculators saw a lot of improvement early on because there was a demand for that. On the other hand, nobody ever asked for a dice roller but the developers simply felt like making one instead of fulfilling a feature request.
Feature requests would be accepted and granted, but most likely they would be turned down with a convoluted answer about complexity, scope and negative impact on the well-being of pandas.

## OMG this code is so ugly!

Yes, it is. This marvellous code was achieved by typing out the code on a classic typewriter, then pushing the sheets through a paper shredder and glueing it back together with shaving cream, before scanning it. Or something close to it.
It was my intent to clean up the code before publishing it. This was two years ago, and all I achieved was delaying the publication.
Perhaps the public shame of this code can spur a developer to clean up her or his code. Let's hope so.

## An endless list of deplorable design choices

* The coding conventions were determined by the position of the moon, on the day that piece of code was developed. 
* Halfway through my javascript code, I decided to switch styles in how I defined prototypes. It seemed like a good choice.
* I didn't use any content framework. Frameworks impress me as top heavy, and they seem to focus on structuring code that I think isn't worth structuring. Yes, "routing, action, view, template" are the holy ~~tri~~ ~~fourinity~~ ~~foursome~~ ~~fournity~~ important. But it seemed silly to put all that in a list of pages that have 1 path, 1 action, 1 view, 1 template.
* I used jQuery only because it came with Bootstrap
* I didn't develop javascript with any developer platform
* I used vanilla Javascript for all functional aspects of the tool, that is not tied to the look and feel. Because.
* I copied bootstrap's files instead of using the CDN. That's considered helping the CDN right?
* Any support for IE is coincidental
* I use SVG for my images. My kids can draw better than me. I feel like I can program a drawing better than I can draw a program... because you can't see the code of the drawing. 
* The library files.. aren't really library files.
* I use preg_match to validate parameters. Don't judge me.
* I have not properly documented most of my code
* Yo dawg, I heard you liked design patterns so I put a builder pattern inside a builder pattern, so you can abstract while you abstract.
* My program cleverly maps configuration parameters to output settings by including flat-files
* The templates are just includes
* I didn't know how to make a proper content managed, and since I didn't use an MVC framework, I just made an include that reads all the parameters. This is also the same file used by 3-4 different webpages. Because, that's smart.
* I didn't optimize the code for computational efficiency. It's primary goal is computations, after all.

## So where does that leave us?

A massive clean-up job. And with proper documentation.