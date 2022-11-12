import 'package:flutter/material.dart';

class RoundImage extends StatefulWidget {
  final ImageProvider<Object> image;
  final double width;
  final double height;
  RoundImage({Key? key, required this.image, this.width = 50.0, this.height = 50.0}) : super(key: key);

  @override
  State<RoundImage> createState() => RoundImageState();
}

class RoundImageState extends State<RoundImage> {
  @override
  Widget build(BuildContext context) {
    return Container(
      width: widget.width,
      height: widget.height,
      decoration:  BoxDecoration(
        shape: BoxShape.circle,
        color: Colors.white,
        image:  DecorationImage(
            fit: BoxFit.contain,
            image: widget.image
        )
      )
    );
  }
}

class TitleContent extends StatefulWidget {
  final String title;
  final IconData icon;
  final String description;
  TitleContent({Key? key, required this.title,required this.icon,required this.description}) : super(key: key);

  @override
  State<TitleContent> createState() => TitleContentState();
}

class TitleContentState extends State<TitleContent> {
  // String label = widget.label ?? 'Tes'; 

  @override
  Widget build(BuildContext context) {
    return Expanded(
      child: Container(
        height: 50,
        // color: Colors.red,
        margin: EdgeInsets.only(left: 10),
        padding: EdgeInsets.symmetric(vertical: 5),
        alignment: Alignment.topLeft,
        child: Column(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,  
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Flexible(

              child: Text(' ${widget.title}', style: TextStyle(fontSize: 17, fontWeight: FontWeight.w600),overflow: TextOverflow.ellipsis,)
            ),
            Row(
              children: [
                Icon(widget.icon, size: 18,),
                Text(" ${widget.description}", style: TextStyle(fontSize: 11, fontWeight: FontWeight.w500),)
              ],
            )
          ],
        )
      ),
    );
  }
}

class FooterContent extends StatefulWidget {
  List<Widget> children;
  FooterContent({Key? key, required this.children}) : super(key: key);

  @override
  State<FooterContent> createState() => FooterContentState();
}

class FooterContentState extends State<FooterContent> {
  // String label = widget.label ?? 'Tes'; 

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: EdgeInsets.only(top: 15),
      child: 
      Row(children: widget.children),
    );
  }
}

class FooterContentChild extends StatefulWidget {
  final String title;
  final Color? color;
  final String description;
  FooterContentChild({Key? key, required this.title, this.color = Colors.blue,required this.description}) : super(key: key);

  @override
  State<FooterContentChild> createState() => FooterContentChildState();
}

class FooterContentChildState extends State<FooterContentChild> {
  // String label = widget.label ?? 'Tes'; 

  @override
  Widget build(BuildContext context) {
    return Expanded(
    flex: 1,
    child: Column(
      mainAxisAlignment: MainAxisAlignment.start,
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Padding(
          padding: const EdgeInsets.only(bottom: 5),
          child: Text(widget.title, style: TextStyle(fontWeight: FontWeight.bold, fontSize: 14, color: Color.fromARGB(255, 90, 91, 103)),),
        ),
        Text(widget.description, style: TextStyle(fontWeight: FontWeight.w600, color: widget.color),),
      ],
    )
  );
  }
}

class ContentBar extends StatefulWidget {
  final Widget roundImage; //
  final Widget titleContent;
  final Widget footerContent;
  final void Function()? onTap;
  ContentBar({Key? key, required this.roundImage,required this.titleContent,required this.footerContent, required this.onTap}) : super(key: key);

  @override
  State<ContentBar> createState() => ContentBarState();
}

class ContentBarState extends State<ContentBar> {
  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: widget.onTap,
      child: Container(
        width: double.infinity,
        padding: EdgeInsets.all(15),
        margin: EdgeInsets.only(bottom: 5, top: 5),
        decoration: BoxDecoration(
          borderRadius: BorderRadius.all(Radius.circular(15)),
          color: Colors.white,
          border: Border.all(color: Color.fromARGB(255, 207, 210, 213), width: 0.2)
        ),
        child: Column(
          children: [
            Container(
              padding: EdgeInsets.only(bottom: 15),
              decoration: BoxDecoration(
                color: Colors.white,
                // boxShadow: [BoxShadow(color: Colors.black, )]
                border: Border(
                  bottom: BorderSide(width: 0.5, color: Color.fromARGB(255, 207, 210, 213)),
                ),
              ),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.start,
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  widget.roundImage,
                  widget.titleContent
                ],
              ),
            ),
          widget.footerContent
          ],
        )
      ),
    );
  }
}
Widget barContent({roundImage, title, footer}){
  return Container(
    width: double.infinity,
    padding: EdgeInsets.all(15),
    margin: EdgeInsets.only(bottom: 5, top: 5),
    decoration: BoxDecoration(
      borderRadius: BorderRadius.all(Radius.circular(15)),
      color: Colors.white,
      border: Border.all(color: Color.fromARGB(255, 207, 210, 213), width: 0.2)
    ),
    child: Column(
      children: [
        Container(
          padding: EdgeInsets.only(bottom: 15),
          decoration: BoxDecoration(
            color: Colors.white,
            // boxShadow: [BoxShadow(color: Colors.black, )]
            border: Border(
              bottom: BorderSide(width: 0.5, color: Color.fromARGB(255, 207, 210, 213)),
            ),
          ),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.start,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              roundImage,
              title
            ],
          ),
        ),
       footer
         
      ],
    )
  );
}