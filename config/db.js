import mongoose from 'mongoose';

export async function connectDB() {
  try {
    await mongoose.connect(process.env.MONGO_URL);
    console.log('✅ MongoDB connecté !');
  } catch (err) {
    console.log('❌ Erreur MongoDB :', err);
    process.exit(1);
  }
}
