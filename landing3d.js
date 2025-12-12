/* 3D Landing Animation with Three.js: Shield + Padlock + DB Cylinder */
(() => {
  const canvas = document.getElementById('securityCanvas');
  if (!canvas) return;

  const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true });
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(45, 1, 0.1, 100);
  camera.position.set(0, 1.2, 6);

  function resize() {
    const w = canvas.clientWidth;
    const h = canvas.clientHeight;
    renderer.setSize(w, h, false);
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
  }
  window.addEventListener('resize', resize);
  resize();

  // Lighting
  const ambient = new THREE.AmbientLight(0x88aaff, 0.7);
  const dir = new THREE.DirectionalLight(0xffffff, 0.8);
  dir.position.set(2, 3, 4);
  scene.add(ambient, dir);

  // Materials
  const blueMat = new THREE.MeshPhysicalMaterial({
    color: 0x3b82f6, roughness: 0.4, metalness: 0.2,
    clearcoat: 0.6, clearcoatRoughness: 0.3
  });
  const whiteMat = new THREE.MeshPhysicalMaterial({ color: 0xeeeeee, roughness: 0.3 });

  // Shield (extruded shape)
  const shieldShape = new THREE.Shape();
  shieldShape.moveTo(0, 1.2);
  shieldShape.quadraticCurveTo(0.9, 1.1, 1.0, 0.2);
  shieldShape.quadraticCurveTo(1.0, -0.8, 0, -1.2);
  shieldShape.quadraticCurveTo(-1.0, -0.8, -1.0, 0.2);
  shieldShape.quadraticCurveTo(-0.9, 1.1, 0, 1.2);

  const shieldGeom = new THREE.ExtrudeGeometry(shieldShape, { depth: 0.25, bevelEnabled: true, bevelSize: 0.03, bevelThickness: 0.05 });
  const shield = new THREE.Mesh(shieldGeom, blueMat);
  shield.rotation.y = Math.PI / 9;
  shield.position.set(-2.1, 0.1, 0);
  scene.add(shield);

  // Padlock (torus shackle + box body)
  const shackle = new THREE.Mesh(new THREE.TorusGeometry(0.5, 0.12, 16, 64, Math.PI), whiteMat);
  shackle.rotation.x = Math.PI / 2;
  shackle.position.set(-2.1, 0.8, 0.2);
  const lockBody = new THREE.Mesh(new THREE.BoxGeometry(0.9, 1.0, 0.4), whiteMat);
  lockBody.position.set(-2.1, 0.0, 0);
  scene.add(shackle, lockBody);

  // Database cylinder
  const db = new THREE.Mesh(new THREE.CylinderGeometry(0.7, 0.7, 1.6, 64, 1, true), blueMat);
  db.position.set(2.0, -0.1, 0);
  scene.add(db);

  // Monitor frame
  const monitor = new THREE.Mesh(new THREE.BoxGeometry(2.8, 1.7, 0.1), new THREE.MeshPhysicalMaterial({ color: 0x1e293b, roughness: 0.6 }));
  monitor.position.set(0, 0.3, 0);
  scene.add(monitor);

  // Login form as plane
  const formCanvas = document.createElement('canvas');
  formCanvas.width = 512; formCanvas.height = 320;
  const ctx = formCanvas.getContext('2d');
  function drawForm() {
    ctx.clearRect(0, 0, formCanvas.width, formCanvas.height);
    ctx.fillStyle = '#1f2937'; ctx.fillRect(0, 0, 512, 320);
    ctx.fillStyle = '#eaf2ff'; ctx.font = 'bold 28px Inter';
    ctx.fillText('Login', 28, 48);
    ctx.fillStyle = '#9fb2cc'; ctx.font = '16px Inter';
    ctx.fillText('Username / Email', 28, 96);
    ctx.fillStyle = '#ffffff22'; ctx.fillRect(28, 108, 456, 40);
    ctx.fillStyle = '#9fb2cc'; ctx.fillText('Password', 28, 168);
    ctx.fillStyle = '#ffffff22'; ctx.fillRect(28, 180, 456, 40);
    ctx.fillStyle = '#3b82f6'; ctx.fillRect(28, 240, 140, 40);
    ctx.fillStyle = '#eaf2ff'; ctx.font = 'bold 16px Inter';
    ctx.fillText('LOGIN', 68, 266);
  }
  drawForm();
  const tex = new THREE.CanvasTexture(formCanvas);
  tex.needsUpdate = true;
  const formPlane = new THREE.Mesh(new THREE.PlaneGeometry(2.5, 1.55), new THREE.MeshBasicMaterial({ map: tex }));
  formPlane.position.set(0, 0.3, 0.06);
  scene.add(formPlane);

  // Subtle animation
  let t = 0;
  function animate() {
    requestAnimationFrame(animate);
    t += 0.01;
    shield.rotation.y = Math.sin(t) * 0.2 + Math.PI/9;
    shackle.rotation.z = Math.sin(t*1.3) * 0.1;
    db.rotation.y += 0.01;
    monitor.rotation.y = Math.sin(t*0.4) * 0.06;
    formPlane.rotation.y = monitor.rotation.y;
    renderer.render(scene, camera);
  }
  animate();
})();
