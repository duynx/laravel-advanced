## Step 1 # Create Project and App in Firebase
Go to https://console.firebase.google.com, create a Project.

After that, you will be given Firebase SDK,

```html
<script>
 var firebaseConfig = {
 apiKey: "<api-key>",
 authDomain: "<xxxxx>.firebaseapp.com",
 databaseURL: "https://<xxxxx>.firebaseio.com",
 projectId: "<xxxxx>",
 storageBucket: "<xxxxx>.appspot.com",
 messagingSenderId: "<xxxxx>",
 appId: "<xxxxx>"
 };

 firebase.initializeApp(firebaseConfig);
</script>
```

## Step 2 # Laravel App
