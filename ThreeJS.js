//ALL ORIGINAL

var clock = new THREE.Clock();
var options = [], spawnerOptions = [], tick = 0;

function THREECanvas(){
    this.width = 800;
    this.height = 400;

    this.deltaTime = 0;

    this.currentNumbers = {
      0 : 0,
      1 : 0,
      2 : 0,
      3 : 0,
      4 : 0
    };

    this.needupdate = true;

    this.scene = new THREE.Scene();
    this.camera = new THREE.PerspectiveCamera( 45, this.width / this.height, 0.1, 1000 );
    this.renderer = new THREE.WebGLRenderer();
    this.loader = new THREE.JSONLoader();

    this.materials = [new THREE.MeshBasicMaterial({color: 0xffffff, side: THREE.DoubleSide})];
    this.meshes = [];
    this.numberWheels = [];
    this.textures = [];

    this.init();
}

THREECanvas.prototype.init = function(){
    this.renderer.setSize(this.width, this.height);
    document.body.appendChild( this.renderer.domElement );

    this.addNumberWheels();

    this.camera.position.z = 100;
    this.camera.position.x = 28;
};

THREECanvas.prototype.createText = function(text, i, k, group){
  var hold = this;
  var loader = new THREE.FontLoader();
  loader.load( './helvetiker_regular.typeface.js', function ( font ) {

    var geometry = new THREE.TextGeometry( text, {
      font: font,
      size: 5,
      height: 2,
      curveSegments: 12,
      bevelEnabled: false,
      bevelThickness: 1,
      bevelSize: 0.5
    } );
    geometry.center();

    var material = new THREE.MeshBasicMaterial( { color: 0xffffff } );
    mesh = new THREE.Mesh( geometry, material );

    mesh.position.x = i * 15;
    mesh.position.z = 15 * Math.sin(k * (Math.PI / 5));
    mesh.position.y = 15 * Math.cos(k * (Math.PI / 5));

    mesh.rotation.x = k * (Math.PI / 5) - (Math.PI / 2);

    group.add(mesh);
  });
};

THREECanvas.prototype.addMeshToScene = function(mesh){
  this.meshes.push( mesh );
  this.scene.add( mesh );
};

THREECanvas.prototype.render = function() {
    this.renderer.render(this.scene, this.camera);
};

THREECanvas.prototype.addNumberWheels = function(){
  var m;
  for(var i=0;i<5;i++){
    var hold = this.createNumberWheel(i);
    hold.rotation.x = Math.PI / 2;
    this.numberWheels.push(hold);
    this.scene.add(hold);
  }
};

THREECanvas.prototype.createNumberWheel = function(i){
  var group = new THREE.Object3D();

  var cylinderGeo = new THREE.BoxGeometry( 20, 20, 20 );
  var material = new THREE.MeshBasicMaterial( { color: 0x000000 } );
  var mesh = new THREE.Mesh( cylinderGeo, material );

  mesh.position.x = i * 15;

  group.add(mesh);

  for(var k=0;k<10;k++){
    this.createText(k, i, k, group);
    if(k === 9)
      return group;
  }
};

THREECanvas.prototype.rotateNumberWheel = function(i, forward){
  this.currentNumbers[i] += forward;

  if(this.currentNumbers[i] > 9)
    this.currentNumbers[i] = 0;
  else if(this.currentNumbers[i] < 0)
    this.currentNumbers[i] = 9;

  this.numberWheels[i].rotation.x -= forward * (Math.PI / 5);
};

function getRandomInt(min, max) {
  min = Math.ceil(min);
  max = Math.floor(max);
  return Math.floor(Math.random() * (max - min)) + min;
}

THREECanvas.prototype.random = function(){
  for(var i=0;i<5;i++){
    var hold = this.currentNumbers[i];
    this.currentNumbers[i] = getRandomInt(0, 10);
    this.numberWheels[i].rotation.x -= ((this.currentNumbers[i] - hold) * (Math.PI / 5));
  }
};

THREECanvas.prototype.getTicketNumber = function(){
  var num = "";
  for(var i=0; i<5;i++){
    num += this.currentNumbers[i];
  }
  return num;
};


$().ready(function(){
  function update()
  {
    this.deltaTime = clock.getDelta();

    myThreeCanvas.render();

    tick += this.deltaTime;

    if (tick < 0) tick = 0;

    requestAnimationFrame(update);
  }
requestAnimationFrame(update);
});