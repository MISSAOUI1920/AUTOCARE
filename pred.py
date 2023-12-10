import joblib
import numpy as np
import sys

# Load the model
with open('model.sav', 'rb') as model_file:
    model = joblib.load(model_file)

# Define the predict function
def predict(val):
    try:
        # Convert command-line arguments to floats
        val = [float(arg) for arg in val]

        # Ensure the length of val matches the number of features expected by the model
        input_data = np.array(val).reshape(1, -1)
        predi = model.predict(input_data)
        return predi[0]
    except Exception as e:
        print("Error:", str(e))
        return None

# Predict using command-line arguments
predicted_value = predict(sys.argv[1:])
if predicted_value is not None:
    print(predicted_value)
