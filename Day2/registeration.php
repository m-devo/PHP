<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  </head>
  <body>
    
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">User Registration</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form action="profile.php" method="POST" class="space-y-6">

        <div>
        <label for="firstName" class="block text-sm/6 font-medium text-gray-900">First Name</label>
        <div class="mt-2">
          <input id="firstName" type="text" name="firstName" required
          class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
        </div>
        </div>

        <div>
        <label for="lastName" class="block text-sm/6 font-medium text-gray-900">Last Name</label>
        <div class="mt-2">
          <input id="lastName" type="text" name="lastName" required
          class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
        </div>
        </div>

        <div>
        <label for="email" class="block text-sm/6 font-medium text-gray-900">Email</label>
          <div class="mt-2">
          <input id="email" type="text" name="email" required 
          class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
        </div>
        </div>


        <div>
        <label for="address" class="block text-sm/6 font-medium text-gray-900">Address</label>
        <div class="mt-2">
          <input id="address" type="text" name="address" required
          class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
        </div>
        </div>

        <div>
        <label for="country" class="block mb-2 text-sm font-medium text-gray-900">Country</label>
        <select id="country" name="country" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm 
        rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option selected value="">Select Country</option>
            <option value="Egypt">Egypt</option>
            <option value="KSA">KSA</option>
            <option value="Oman">Oman</option>
            <option value="Bahrain">Bahrain</option>
        </select>
        </div>
        
        <div>
            <h3 class="block text-sm/6 font-medium text-gray-900">Sex</h3>
            <div class="mt-2 flex space-x-6">
                <div class="flex items-center">
                    <input id="gender-male" type="radio" value="male" name="sex" required
                     class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                    <label for="gender-male" class="ml-2 text-sm font-medium text-gray-900">Male</label>
                </div>
                <div class="flex items-center">
                    <input id="gender-female" type="radio" value="female" name="sex" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                    <label for="gender-female" class="ml-2 text-sm font-medium text-gray-900">Female</label>
                </div>
            </div>
        </div>

        
        <div>
            <h3 class="block text-sm/6 font-medium text-gray-900">Skills</h3>
            <div class="mt-2 grid grid-cols-2 gap-4">
                <div class="flex items-center">
                    <input id="skill-php" type="checkbox" value="PHP" name="skills[]" 
                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="skill-php" class="ml-2 text-sm font-medium text-gray-900">PHP</label>
                </div>
                <div class="flex items-center">
                    <input id="js" type="checkbox" value="JS" name="skills[]" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" checked>
                    <label for="js" class="ml-2 text-sm font-medium text-gray-900">JS</label>
                </div>
                <div class="flex items-center">
                    <input id="mysql" type="checkbox" value="MySQL" name="skills[]" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" checked>
                    <label for="mysql" class="ml-2 text-sm font-medium text-gray-900">MySQL</label>
                </div>
                <div class="flex items-center">
                    <input id="postgresql" type="checkbox" value="PostgresQL" name="skills[]" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="postgresql" class="ml-2 text-sm font-medium text-gray-900">PostgresQL</label>
                </div>
            </div>
        </div>
        
        <div>
        <label for="username" class="block text-sm/6 font-medium text-gray-900">Username</label>
          <div class="mt-2">
          <input id="username" type="text" name="username" required 
          class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
        </div>
        </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
        </div>
        <div class="mt-2">
          <input id="password" type="password" name="password" 
          required autocomplete="new-password" 
          class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 
          -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 
          focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
        </div>
      </div>
      
      <div>
        <label for="department" class="block text-sm/6 font-medium text-gray-900">Department</label>
          <div class="mt-2">
          <input id="department" type="text" name="department" value="OpenSource" readonly
          class="block w-full rounded-md bg-gray-100 px-3 py-1.5 text-base text-gray-500 outline-1 -outline-offset-1 outline-gray-300 sm:text-sm/6" />
        </div>
        </div>
        
        <div class="flex justify-between space-x-4 pt-4">
        <button type="submit" 
        class="flex-1 justify-center rounded-md bg-indigo-600 px-3 
        py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 
        focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
        <button type="reset" 
        class="flex-1 justify-center rounded-md bg-gray-500 px-3 
        py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-gray-400 
        focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">Reset</button>
      </div>
    </form>
  </div>
</div>
  </body>
</html>