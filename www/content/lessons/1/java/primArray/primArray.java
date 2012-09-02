import java.awt.*;
import java.lang.*;
import java.util.Vector;
import node;
import graph;
import primSolution;


public class primArray extends java.applet.Applet {


    graph gr=new graph(13,55,45,45);
    graphArray gra=new graphArray(515,55,33);
    primSolution p=new primSolution();
    final int n=10;
    int ary=85,arx=200,box=15;
    Graphics d,gtrue;
    Image im;
    Font f=new Font("Arial ",Font.BOLD,10);
    int A[][]=new int[n][n];
    boolean Ahelp[][]=new boolean[n][n];
    boolean Cols[]=new boolean[n];
    int xi,yi;
    int HoldMarks[]=new int[n];
    boolean allDesign;
    int point=0;
    int step=-1;

  public void resetData(){
     for (int i=0;i<n;i++){
         Cols[i]=false;
     for (int j=0;j<n;j++)
        Ahelp[i][j]=false;
      }
     for ( int help=0;help<n;help++)
        HoldMarks[help]=0;
  }

  public void putRandomData(){
      resetData();
      point=0;
      step=-1;
      gr.setMaximumNodes(n,4,3,true);
      do {
        gr.putRandomNodes();
        p.initialize(gr);
      }while (!p.synecticos());

      p.initialize(gr);
      gra.initialize();
      A=gr.getArray(n);
      setActive();
      repaint();
    }

void setActive(){
  for (int i=0;i<n;i++)
    for (int j=0;j<n;j++)
      if (A[i][j]!=0) Ahelp[i][j]=true;
}


public void init() {
    //{{INIT_CONTROLS
    im=createImage(size().width,size().height);
    d=im.getGraphics();
    gtrue=getGraphics();
    d.setFont(f);
    setLayout(null);
    button1=new Button("Step Solution");
    add(button1);
    button1.reshape(5,370,120,20);
    button2=new Button("Solve Problem");
    add(button2);
    button2.reshape(130,370,120,20);
    button3=new Button("New Problem");
    add(button3);
    button3.reshape(255,370,120,20);
    putRandomData();
    //}}
}

    void DrawElement( int num,int i,int j) {
      String s;
      s=String.valueOf(num);
      d.setColor(Color.black);
      d.drawString(s,arx+box*j+2,ary+box*(i+1)-4);
    }


   void MarkSquare ( boolean tag,int i,int j) {
    int hold1,hold2;

     if (tag)
        d.setColor(Color.pink);
     else
       d.setColor(Color.gray);
     hold1=arx+box*j+1;
     hold2=ary+box*i+1;
     d.fillRect(hold1,hold2,box-1,box-1);
     if (A[i][j]!=0)
       DrawElement(A[i][j],i,j);
     Ahelp[i][j]= false;
   }

   void MarkLine( int j) {
     for (int k=0;k<n;k++)
        MarkSquare( false,k,j);
    Cols[j]= true;
   }

   void Tick(int i) {
    d.setColor(Color.blue);
    d.drawLine(box*n+arx+box/3,ary+box/2+box*i,box*n+arx+box/2,ary+box-5+box*i);
    d.drawLine(box*n+arx+box/2,ary+box-5+box*i,box*n+arx+box,ary-1+box*i);
    HoldMarks[point]=i;
    point++;
   }

   void PrintArray( int Pinakas[][]) {
    int indexi,indexj;

    for (indexi=0;indexi<n;indexi++) {
      for (indexj=0;indexj<n;indexj++)  {
         if (Pinakas[indexi][indexj]!=0)
           DrawElement(Pinakas[indexi][indexj],indexi,indexj);
      }

    }

   }

   int FindMin() {
    int min=1000,j=0,i=0;
    int hi=0,hj=0;

    for (i=0;i<n;i++){
      if (isinHoldMarks(i))
      for (j=0;j<n;j++) {
        if ( (Ahelp[i][j]==true) && (A[i][j]<min) && (A[i][j]!=0)){
            min=A[i][j];
            hi=i;hj=j;
        }
      }
    }
    xi=hi;
    yi=hj;

    return min;
   }

  boolean AreElements() {
   int j,i;
    for (i=0;i<n;i++){
     if (isinHoldMarks(i))
     for (j=0;j<n;j++) {
         if (( A[i][j]!=0)&&(Ahelp[i][j])) {
           return true;
        }
     }
    }
    return false;
  }

  boolean isinHoldMarks(  int elem) {
    int help;
    for (help=0;help<n;help++) {
        if (elem==HoldMarks[help]) {
            return true;
        }
    }
    return false;
  }


  public void redraw(){
    int kx;
    d.setColor(Color.yellow);
    d.fillRect(arx,ary,box*n,box*n);
    d.setColor(Color.black);
    d.drawRect(arx,ary,box*n,box*n);

    for (kx=arx+box;kx<=arx+box*n;kx=kx+box)
         d.drawLine(kx,ary,kx,ary+box*n);
    for (kx=ary+box;kx<=ary+box*n;kx=kx+box)
         d.drawLine(arx,kx,arx+box*n,kx);
    d.setColor(Color.black);
    for (int i=1;i<=n;i++){
      if (i!=10)
        d.drawString(String.valueOf(i),arx-12,ary+box*i-2);
      else
        d.drawString(String.valueOf(i),arx-16,ary+box*i-2);
      d.drawString(String.valueOf(i),arx+box*(i-1)+2,ary-6);
    }

    PrintArray(A);
  }

  public void nextStep(int delay){

      int telos;
      int is,themin;
      boolean are;


      if (step==0) {

          // Bhma   00
          xi=0;
          yi=0;
          Tick(yi);
          MarkLine(yi);
          gra.addNode(1,0,A[0][0]);
          drawData();
        }

        // Bhma    1

      if (step>0){
        are=AreElements();
        if (are) {
          themin=FindMin();
          MarkSquare(true,xi,yi);
          gtrue.drawImage(im,0,0,this);
          try {Thread.sleep(delay);}
          catch (InterruptedException e) {}
          Tick(yi);
          MarkLine(yi);
          gra.addNode(yi+1,xi+1,A[xi][yi]);
          drawData();

        }
        else{
          for (int i=0;i<n;i++)
          Cols[i]=false;
          step=-1;
          redraw();
          point=0;
          setActive();
          for ( int help=0;help<n;help++)
              HoldMarks[help]=0;
          gra.initialize();
          drawData();
        }
      }
  }

  public void drawData(){
     Font med=new Font("Arial",Font.BOLD+Font.ITALIC,12);
     Rectangle r=bounds();

      d.setColor(Color.white);
      d.fillRect(r.x,r.y,r.width,r.height);
      d.setColor(Color.black);
      d.drawRect(r.x,r.y,r.width-1,r.height-1);
      d.setFont(med);
      d.setColor(Color.black);
      d.fillRect(r.x+1,r.y+1,r.width-3,20);
      d.setColor(Color.white);
      d.drawRect(r.x+1,r.y+1,r.width-3,20);
      d.drawString("Genetic tree finder using the Prim Algorithm & the Adjoining Array.",r.x+10,r.y+15);
      d.setColor(Color.orange);
      d.fillRect(3,45,173,320);
      d.fillRect(181,45,194,320);
      d.fillRect(380,45,280,320);
      d.setColor(Color.black);
      d.drawRect(3,45,173,320);
      d.drawRect(181,45,194,320);
      d.drawRect(380,45,280,320);


      d.setFont(f);
      d.drawString("Greed Exhibition by :Papagelis Athanasios",450,380);
      d.drawString(" & Drosos Nikolaos",565,390);
      d.drawString("Graph",10,40);
      d.drawString("Adjoining Array of Graph",190,40);
      d.drawString("Genetic tree",390,40);

      redraw();
      point=0;
      for (int i=0;i<n;i++)
        if (Cols[i]){
           MarkLine(i);
           Tick(i);
      }
      d.setColor(Color.black);
      gr.drawGraph(d);
      gra.drawGraph(d);
      gra.printCost(d,400,360);
      gtrue.drawImage(im,0,0,this);
    }

  public void update(Graphics e)
    {
        paint(e);
    }

    public void paint(Graphics e) {
      drawData();
    }


    public void clickedButton1() {
        step++;
        allDesign=false;
        nextStep(500);
    }

    public void clickedButton2(){
        for (int i=step+1;i<n;i++){
         step++;
         nextStep(0);
         drawData();
        }
    }

    public void clickedButton3() {
        step=0;
        putRandomData();
    }

    public boolean handleEvent(Event event) {

        if (event.id == Event.ACTION_EVENT && event.target == button1) {
            clickedButton1();
            return true;
        }
        else
        if (event.id == Event.ACTION_EVENT && event.target == button2) {
            clickedButton2();
            return true;
        }
        else
        if (event.id == Event.ACTION_EVENT && event.target == button3) {
            clickedButton3();
            return true;
        }

        return super.handleEvent(event);
    }
    //{{DECLARE_CONTROLS
    Button button1;
    Button button2;
    Button button3;


    //}}

}


class graphArray {
  int counter=0;
  int x,y,step,cost;
  int costs=0;
  Vector v=new Vector();


  public graphArray(int x,int y,int step){

    this.x=x;
    this.y=y;
    this.step=step;
  }


  public void printCost(Graphics d,int x,int y){
    d.drawString("Genetic tree cost : "+String.valueOf(costs),x,y);
  }

  public void initialize(){
    v.removeAllElements();
    costs=0;
  }

  public node findNode(int number){
    node hNode;
    for (int i=0;i<v.size();i++){
        hNode=(node)v.elementAt(i);
        if (hNode.number==number) return hNode;
    }
    return null;
  }


  public void setLeftDown(node father,node son,int cost){
        father.leftdownx=son.x;
        father.leftdowny=son.y;
        father.leftdownc=cost;
        father.leftdownn=son.number;
    }

    public void setRightDown(node father,node son,int cost){
        father.rightdownx=son.x;
        father.rightdowny=son.y;
        father.rightdownc=cost;
        father.rightdownn=son.number;
    }

    public void setDown(node father,node son,int cost){
        father.downx=son.x;
        father.downy=son.y;
        father.downc=cost;
        father.downn=son.number;
    }

    public void setRight(node father,node son,int cost){
        father.rightx=son.x;
        father.righty=son.y;
        father.rightc=cost;
        father.rightn=son.number;
    }

    public void setLeft(node father,node son,int cost){
        father.leftx=son.x;
        father.lefty=son.y;
        father.leftc=cost;
        father.leftn=son.number;
    }
    public void setAllDownNodes(node father,int change){
        node theNode;
        node helpNode,helpNode2;

        for (int i=0;i<v.size();i++){
          theNode=(node)v.elementAt(i);
          helpNode=theNode;
          while (helpNode.upn!=0) {
            if (helpNode.upn==father.number)
            {
              theNode.x+=change;
              helpNode2=findNode(theNode.upn);
              if (helpNode2.rightn==theNode.number)
                 helpNode2.rightx+=change;
              if (helpNode2.downn==theNode.number)
                 helpNode2.downx+=change;
              if (helpNode2.leftdownn==theNode.number)
                 helpNode2.leftdownx+=change;
              if (helpNode2.rightdownn==theNode.number)
                 helpNode2.rightdownx+=change;

            }
            helpNode=findNode(helpNode.upn);
          }
        }
    }


  public void checkForSamexy(){
    node theNode;
    node helpNode,helpNode2;
    boolean found=true;
    node n;

       for (int loop=v.size()-1;loop>=0;loop--)
       {
        n=(node)v.elementAt(loop);
        for (int i=0;i<v.size();i++){
          theNode=(node)v.elementAt(i);
          if ((theNode!=n) && (theNode.x==n.x) && (theNode.y==n.y)){
            found=true;
            helpNode=findNode(theNode.upn);
            helpNode2=findNode(n.upn);
            if ( helpNode2.x>n.x)
              setAllDownNodes(helpNode,-step);
            else if ( helpNode2.x==n.x){
                if (helpNode.x<theNode.x)
                  setAllDownNodes(helpNode,-step);
            }
            else
              setAllDownNodes(helpNode,step);
          }
        }
       }
  }

  public void addNode(int number,int father,int cost){
    node myNode=new node();
    node hNode;
    node downNode;

    costs+=cost;
    if (v.size()==0) {
       myNode.setxy(number,x,y);
       myNode.upn=0;
       v.addElement(myNode);
       return;
    }

    for (int i=0;i<v.size();i++){
        hNode=(node)v.elementAt(i);
        if (hNode.number==father) { //we found the father
           if (hNode.downx==0){
             if (hNode.leftdownx==0) //elegxoume gia yparxon dejio kombo
                                  //mporei na yparjei problhma me tis strofes
               myNode.setxy(number,hNode.x,hNode.y+step);
             else
               myNode.setxy(number,hNode.leftdownx+step,hNode.y+step);


             myNode.upn=father;
             v.addElement(myNode);
             setDown(hNode,myNode,cost);
           }
           else
           if ((hNode.downx!=0) && (hNode.leftdownx!=0) && (hNode.rightdownx!=0) && (hNode.rightx!=0))
           {
               myNode.setxy(number,hNode.x-step*2,hNode.y+step);
               myNode.upn=father;
               v.addElement(myNode);
               setLeft(hNode,myNode,cost);
           }
           else
           if ((hNode.downx!=0) && (hNode.leftdownx!=0) && (hNode.rightdownx!=0))
           {
               myNode.setxy(number,hNode.x+step*2,hNode.y+step);
               myNode.upn=father;
               v.addElement(myNode);
               setRight(hNode,myNode,cost);
           }
           else
           {
            downNode=findNode(hNode.downn);//briskoume to node apo katw
             //mhdenizoume to apo kato tou patera
             hNode.downx=0;
             hNode.downy=0;
             hNode.downn=0;
             myNode.setxy(number,hNode.x+step,hNode.y+step);
             myNode.upn=father;
             downNode.x=hNode.x-step;
             v.addElement(myNode);
             setLeftDown(hNode,downNode,hNode.downc);
             setAllDownNodes(downNode,-step);
             hNode.downc=0;
             setRightDown(hNode,myNode,cost);
           }
          checkForSamexy();
        }
    }
  }


    public void drawGraph(Graphics g){
        node hNode;

        for (int loop1=0;loop1<v.size();loop1++){
            hNode=(node)v.elementAt(loop1);
            // left profit
            if  (hNode.leftx!=0){
                g.drawLine(hNode.x+10,hNode.y+10,
                           hNode.leftx+2,hNode.lefty+10 );
                g.drawString(String.valueOf(hNode.leftc),
                   hNode.x+((hNode.leftx-hNode.x)/2)+8,
                   hNode.y+((hNode.lefty-hNode.y)/2)+11);
            }
            // right profit
            if  (hNode.rightx!=0){
                g.drawLine(hNode.x+10,hNode.y+10,
                           hNode.rightx+2,hNode.righty+10 );
                g.drawString(String.valueOf(hNode.rightc),
                   hNode.x+((hNode.rightx-hNode.x)/2)+8,
                   hNode.y+((hNode.righty-hNode.y)/2)+11);
            }
            // down profit
            if  (hNode.downx!=0){
                g.drawLine(hNode.x+10,hNode.y+10,
                           hNode.downx+10,hNode.downy+10 );
                g.drawString(String.valueOf(hNode.downc),
                   hNode.x+((hNode.downx-hNode.x)/2)+13,
                   hNode.y+((hNode.downy-hNode.y)/2)+15);
            }
            //right-down
            if  (hNode.rightdownx!=0){
                g.drawLine(hNode.x+10,hNode.y+10,
                           hNode.rightdownx+10,hNode.rightdowny+10 );
                g.drawString(String.valueOf(hNode.rightdownc),
                   hNode.x+((hNode.rightdownx-hNode.x)/2)+12,
                   hNode.y+((hNode.rightdowny-hNode.y)/2)+12);
            }
           //leftdown
            if  (hNode.leftdownx!=0){
                g.drawLine(hNode.x+10,hNode.y+10,
                           hNode.leftdownx+10,hNode.leftdowny+10 );
                g.drawString(String.valueOf(hNode.leftdownc),
                   hNode.x+((hNode.leftdownx-hNode.x)/2)+3,
                   hNode.y+((hNode.leftdowny-hNode.y)/2)+12);
            }
        }

          for (int loop1=0;loop1<v.size();loop1++){
                hNode=(node)v.elementAt(loop1);
                g.setColor(Color.lightGray);
                g.fillOval(hNode.x,hNode.y,18,18);
                g.setColor(Color.black);
                g.drawOval(hNode.x,hNode.y,18,18);
                if (hNode.number!=10)
                  g.drawString(String.valueOf(hNode.number),hNode.x+6,hNode.y+12);
                else
                  g.drawString(String.valueOf(hNode.number),hNode.x+4,hNode.y+12);
          }
        }

}







