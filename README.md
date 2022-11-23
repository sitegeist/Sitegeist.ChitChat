# Sitegeist.ChitChat
## Deterministic randomized text generator for styleguide props 

!!! This package is work in progress ... everything in here might change anytime !!!

Presentational components for the monocle styleguide tend to have longish @styleguide.props that are hard to maintain, 
tend to overshadow the actual component and often do not provide enough diversion to actually test different text lengths.

ChitChat generates pseudo random texts that can be used in styleguide props. The texts are generated uniquely for each
insertion point (fusion path) using pseudo random numbers.

The styleguide only specifies that a headline follows by two paragraphs and a list is needed. **No need to copy amd past the 
same lorem ipsum texts over and over again!**

```neosfusion
dummytext = afx`
    <Sitegeist.ChitChat:Headline level="2" />
    <Sitegeist.ChitChat:Paragraph />
    <Sitegeist.ChitChat:Paragraph />
    <Sitegeist.ChitChat:List />
`
```

The implementation was inspired by the js library getlorem https://github.com/lukehaas/getlorem/. 
Also the word list we use started as a copy from getlorem.

### Authors & Sponsors

* Melanie Wüst - wuest@sitegeist.de
* Martin Ficzel - ficzel@sitegeist.de

*The development and the public-releases of this package is generously sponsored
by our employer http://www.sitegeist.de.*

## Installation

Sitegeist.ChitChat is available via packagist and can be installed with the command `composer require sitegeist/chitchat`.

We use semantic-versioning so every breaking change will increase the major-version number.

## Usage



```neosfusion
prototype(Vendor.Site:ChitChat) < prototype(Neos.Fusion:Component) {
    @styleguide {
        title = "ChitChat"
        props.text = afx`
            <Sitegeist.ChitChat:Headline level="1" />
            <Sitegeist.ChitChat:Headline level="2" />
            <Sitegeist.ChitChat:Paragraph />
            <Sitegeist.ChitChat:Paragraph />
            <Sitegeist.ChitChat:Paragraph />
            <Sitegeist.ChitChat:Headline level="3" />
            <Sitegeist.ChitChat:List />
            <Sitegeist.ChitChat:Headline level="3" />
            <Sitegeist.ChitChat:List ordered />
        `
    }

    text = null

    renderer = afx`
        <div>{props.text}</div>
    `
}
```

## Contribution

We will gladly accept contributions. Please send us pull requests.
