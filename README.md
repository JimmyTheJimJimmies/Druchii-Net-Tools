# The Druchii.net Tools

A set of theory crafting and gaming tools for the fantasy war-gaming hobby, including:
* A combat calculator, supporting 9th Age, Warhammer Fantasy Battles 8th edition and Age of Sigmar.
* A dice roller

More tools will be added in the future.

## Table of Contents


## Installing and requirements

The Druchii.net tools require a PHP enabled webserver. That should be it. Just move the content of the project to the public_html folder, or any subfolder and it should work out of the box.

There is no support for customization or templating for the time being.


## Live code and support

The Druchii.net Tools are created and written for the Druchii.net community, where you can find a live copy and support:
* [The Druchii.net Tools on the Druchii.net Community site](http://tools.druchii.net)
* [Get support on the Druchii.net suggestions board](http://www.druchii.net/viewforum.php?f=5)
* [Join the discussion, at Druchii.net] (http://www.druchii.net)

Of course, for code specific issues (suggestions, bug reports), feel free to use the facilities offered by GitHub.
* [The Druchii.net Tools on GitHub](https://github.com/DaeronSyriath/Druchii-Net-Tools)


## The project

The druchii.net tools were designed to tackle a collection of specific demands and goals:
* ''Accessible statistical analysis''. Detailed statistical analysis of unit performance in the game required more challenging calculations. The goal was to tackle these calculations, and offer the use and results in an accessible, intuitive way.
* ''Community project''. The tools would be seen as a community project, closely following up on feature requests and demands from the community. Only one such request had to be delayed for a future release, expected to be implemented by the end of 2016.
* ''Used for discussions or gaming''. A key feature of the tools is their ease of use in discussions, and/or games. This encouraged a mobile-friendly design and easy link to results.
* ''Accidental pet project''. Since the original version was built and maintained by a single developer, with a passion for the community and the statistical analysis, it turned to be a pet project. This greatly stimulated the development of some features at the cost of code quality.
* ''New to open source''. The code of the project has only just been released. This has somewhat shifted the focus of the development. Customization and portability, as well as code quality became more important. We understand both customizability and code quality leave much to be desired. We hope to improve both in future releases.

## Future releases, planned features

### Clean-up and documentation

The first steps are to clean up the code a bit, and improve the documentation. Even the bad code and designs will receive documentation. 
There may be a few redundant files in there as well, which need to be removed.

### Customisation

In spite of the dramatic code quality, there's a fair few abstractions that permit customization. These are mostly the result of expected feature expansions that were never implemented. Since the tools are now open-source, ease of customisation becomes more important and worth the investment.

### Comp Comparator

A tool that is under construction right now is a comp pack comparator for Age of Sigmar. This will be developed in a separate branch, until it is ready to be merged.

### Machine Learning for Pile-in strategies

Another tool under development is focused on a genetic algorithm to develop pile-in strategies. This should help us to test unit formations and pile-in counters.

### Age of Sigmar special rules

Many of the abilities in Age of Sigmar involve a special rule that can not be expressed as a modifier on a roll. These require a specific handler and, unfortunately, a lot of custom code for each rule.

### Combat performance comparator

A future release will permit multiple combat profiles to be compared, with the result being plotted in a single graphic. We noticed that combat performance is occasionally compared, and that the graphical load of such comparisons can hinder the discussions. By combining different profiles in a single graph, we could reduce the space required for such a comparison.
This should be supported for all the gaming platforms.

### Unit performance decay

As a step-up to a combat resolution calculator, it may prove useful to observe a unit's performance over time and show its decay in performance as it takes damage.

### Combat resolution calculator

Eventually, the ultimate theory crafting goal is to have an accurate calculation of combat resolution.


## Contributing

We welcome any:
* advice on code design
* advice on portability, customisation support
* coding
* feature suggestions and/or requests
* bug reports

Code contributions may require up to a month to validate.

## Authors

The code was developed by @DaeronSyriath for [the Druchii.net community](http://www.druchii.net)

